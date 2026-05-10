<?php declare(strict_types=1);

namespace yii2\common\services\audit;

use yii2\common\models\audit\AuditOrder;
use yii2\common\models\audit\AuditPage;
use yii2\common\models\audit\AuditRun;
use yii2\common\models\audit\Report;
use yii2\common\services\audit\checks\DuplicateCheckService;
use yii2\common\services\audit\checks\MetaCheckService;
use yii2\common\services\audit\checks\SiteCheckService;
use yii2\common\services\audit\crawler\CrawlerService;
use yii2\common\services\audit\llm\LlmClientException;
use yii2\common\services\audit\report\HtmlReportRenderer;
use yii2\common\services\audit\report\PdfReportRenderer;
use yii2\common\services\audit\report\ReportAssembler;

/**
 * Оркестрирует pipeline запуска аудита: crawl, checks, report, PDF, finalize.
 *
 * @package yii2\common\services\audit
 */
final class AuditRunnerService
{
    /**
     * Создаёт сервис pipeline аудита.
     *
     * @param CrawlerService $crawler Crawler.
     * @param MetaCheckService $metaCheck Проверки страниц.
     * @param DuplicateCheckService $duplicateCheck Проверки дублей.
     * @param SiteCheckService $siteCheck Проверки уровня сайта.
     * @param ReportAssembler|null $reportAssembler Сборщик отчёта.
     * @param HtmlReportRenderer $htmlRenderer HTML renderer.
     * @param PdfReportRenderer $pdfRenderer PDF renderer.
     * @return void
     */
    public function __construct(
        private readonly CrawlerService $crawler = new CrawlerService(),
        private readonly MetaCheckService $metaCheck = new MetaCheckService(),
        private readonly DuplicateCheckService $duplicateCheck = new DuplicateCheckService(),
        private readonly SiteCheckService $siteCheck = new SiteCheckService(),
        private readonly ?ReportAssembler $reportAssembler = null,
        private readonly HtmlReportRenderer $htmlRenderer = new HtmlReportRenderer(),
        private readonly PdfReportRenderer $pdfRenderer = new PdfReportRenderer(),
    ) {
    }

    /**
     * Создаёт новый запуск аудита для заказа.
     *
     * @param AuditOrder $order Заказ аудита.
     * @return AuditRun Новый запуск аудита.
     * @throws \RuntimeException Если запуск не удалось сохранить.
     */
    public function createRun(AuditOrder $order): AuditRun
    {
        $run = new AuditRun([
            'order_id' => $order->id,
            'status' => AuditRun::STATUS_QUEUED,
            'page_limit' => $order->page_limit,
            'crawler_config_json' => [
                'maxDepth' => 2,
                'timeout' => (int)($_ENV['AUDIT_REQUEST_TIMEOUT'] ?? 8),
                'maxResponseBytes' => (int)($_ENV['AUDIT_MAX_RESPONSE_BYTES'] ?? 1048576),
            ],
        ]);

        if (!$run->save()) {
            throw new \RuntimeException('Не удалось создать запуск аудита: ' . json_encode($run->errors, JSON_UNESCAPED_UNICODE));
        }

        $order->workflow_status = AuditOrder::WORKFLOW_RUNNING;
        $order->touchUpdatedAt();
        $order->save(false);

        return $run;
    }

    /**
     * Выполняет crawler и сохраняет страницы.
     *
     * @param AuditRun $run Запуск аудита.
     * @return void
     * @throws \Throwable При ошибке crawl или сохранения.
     */
    public function crawl(AuditRun $run): void
    {
        $this->markRun($run, AuditRun::STATUS_CRAWLING, ['started_at' => date('Y-m-d H:i:s')]);
        $domain = $run->order?->domain;
        if ($domain === null) {
            throw new \RuntimeException('Домен запуска аудита не найден.');
        }

        AuditPage::deleteAll(['audit_run_id' => $run->id]);
        $pages = $this->crawler->crawl($domain->normalized_url, (int)$run->page_limit);

        foreach ($pages as $pageDto) {
            $page = new AuditPage([
                'audit_run_id' => $run->id,
                'url' => $pageDto->url,
                'normalized_url' => $pageDto->normalizedUrl,
                'http_status' => $pageDto->httpStatus,
                'content_type' => $pageDto->contentType,
                'title' => $pageDto->title,
                'description' => $pageDto->description,
                'canonical' => $pageDto->canonical,
                'h1_json' => $pageDto->h1,
                'links_json' => $pageDto->links,
                'forms_json' => $pageDto->forms,
                'schema_json' => $pageDto->schema,
                'fetched_at' => date('Y-m-d H:i:s'),
            ]);

            if (!$page->save()) {
                throw new \RuntimeException('Не удалось сохранить страницу аудита: ' . json_encode($page->errors, JSON_UNESCAPED_UNICODE));
            }
        }

        $run->pages_scanned = count($pages);
        $run->touchUpdatedAt();
        $run->save(false);
    }

    /**
     * Выполняет deterministic checks и сохраняет findings.
     *
     * @param AuditRun $run Запуск аудита.
     * @return void
     * @throws \RuntimeException Если checks не смогли сохранить findings.
     */
    public function runChecks(AuditRun $run): void
    {
        $this->markRun($run, AuditRun::STATUS_CHECKING);
        $domain = $run->order?->domain;
        foreach (AuditPage::find()->where(['audit_run_id' => $run->id])->each() as $page) {
            if ($page instanceof AuditPage) {
                $this->metaCheck->check($page);
            }
        }
        $this->duplicateCheck->check((int)$run->id);
        if ($domain !== null) {
            $this->siteCheck->check((int)$run->id, $domain->normalized_url);
        }
    }

    /**
     * Генерирует черновик отчёта и HTML-файл.
     *
     * @param AuditRun $run Запуск аудита.
     * @return Report Отчёт.
     * @throws \Throwable Если отчёт не удалось создать или отрендерить.
     */
    public function generateReport(AuditRun $run): Report
    {
        try {
            $this->markRun($run, AuditRun::STATUS_REPORTING);
            $report = ($this->reportAssembler ?? new ReportAssembler())->assemble($run);
            $this->htmlRenderer->render($report);
        } catch (\Throwable $e) {
            $this->fail($run, $e);
            throw $e;
        }

        return $report;
    }

    /**
     * Генерирует PDF для отчёта.
     *
     * @param Report $report Отчёт.
     * @return void
     * @throws \RuntimeException Если PDF не удалось создать.
     */
    public function generatePdf(Report $report): void
    {
        $run = $report->run;
        if ($run !== null) {
            $this->markRun($run, AuditRun::STATUS_PDF);
        }
        $this->pdfRenderer->render($report);
    }

    /**
     * Финализирует успешный запуск аудита.
     *
     * @param AuditRun $run Запуск аудита.
     * @return void
     */
    public function finalize(AuditRun $run): void
    {
        $this->markRun($run, AuditRun::STATUS_COMPLETED, ['finished_at' => date('Y-m-d H:i:s')]);
        $order = $run->order;
        if ($order !== null) {
            $order->workflow_status = AuditOrder::WORKFLOW_REPORT_REVIEW;
            $order->touchUpdatedAt();
            $order->save(false);
        }
    }

    /**
     * Помечает запуск аудита ошибочным.
     *
     * @param AuditRun $run Запуск аудита.
     * @param \Throwable $exception Исключение pipeline.
     * @return void
     */
    public function fail(AuditRun $run, \Throwable $exception): void
    {
        $this->markRun($run, AuditRun::STATUS_FAILED, [
            'finished_at' => date('Y-m-d H:i:s'),
            'error_message' => $this->safeErrorMessage($exception),
        ]);

        $order = $run->order;
        if ($order !== null) {
            $order->workflow_status = AuditOrder::WORKFLOW_FAILED;
            $order->touchUpdatedAt();
            $order->save(false);
        }
    }

    /**
     * Обновляет статус запуска аудита.
     *
     * @param AuditRun $run Запуск аудита.
     * @param string $status Новый статус.
     * @param array $attributes Дополнительные атрибуты.
     * @return void
     */
    private function markRun(AuditRun $run, string $status, array $attributes = []): void
    {
        $run->status = $status;
        foreach ($attributes as $attribute => $value) {
            $run->{$attribute} = $value;
        }
        $run->touchUpdatedAt();
        $run->save(false);
    }

    /**
     * Возвращает безопасное сообщение для хранения в audit_runs.error_message.
     *
     * @param \Throwable $exception Исключение pipeline.
     * @return string Сообщение без сырого LLM response.
     */
    private function safeErrorMessage(\Throwable $exception): string
    {
        if ($exception instanceof LlmClientException) {
            $code = (int)$exception->getCode();
            if ($code >= 100 && $code <= 599) {
                return "LLM provider HTTP {$code}.";
            }

            return 'LLM provider request failed.';
        }

        return $exception->getMessage();
    }
}
