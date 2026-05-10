<?php declare(strict_types=1);

namespace yii2\common\services\audit\report;

use yii2\common\models\audit\AuditRun;
use yii2\common\models\audit\Finding;
use yii2\common\models\audit\Report;
use yii2\common\models\audit\ReportTask;
use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\llm\LlmCallLogService;
use yii2\common\services\audit\llm\LlmClientFactory;
use yii2\common\services\audit\llm\LlmClientInterface;
use yii2\common\services\audit\llm\LlmReportResponseValidator;

/**
 * Собирает черновик отчёта и задачи на основе deterministic findings и LLM-клиента.
 *
 * @package yii2\common\services\audit\report
 */
final class ReportAssembler
{
    private readonly LlmClientInterface $llmClient;

    /**
     * Создаёт assembler отчётов.
     *
     * @param LlmClientInterface|null $llmClient LLM-клиент или null для env-фабрики.
     * @param LlmReportResponseValidator $validator Валидатор LLM-ответа.
     * @param LlmCallLogService $logService Сервис безопасного логирования LLM-вызовов.
     * @return void
     * @throws \yii2\common\services\audit\llm\LlmClientException Если env provider настроен некорректно.
     */
    public function __construct(
        ?LlmClientInterface $llmClient = null,
        private readonly LlmReportResponseValidator $validator = new LlmReportResponseValidator(),
        private readonly LlmCallLogService $logService = new LlmCallLogService(),
    ) {
        $this->llmClient = $llmClient ?? (new LlmClientFactory())->create();
    }

    /**
     * Создаёт или обновляет черновик отчёта.
     *
     * @param AuditRun $run Запуск аудита.
     * @return Report Сохранённый отчёт.
     * @throws \RuntimeException Если отчёт или задача не сохраняются.
     */
    public function assemble(AuditRun $run): Report
    {
        $order = $run->order;
        $domain = $order?->domain;
        $findings = Finding::find()->where(['audit_run_id' => $run->id])->orderBy(['id' => SORT_ASC])->all();
        $payload = [];
        $summary = ['critical' => 0, 'medium' => 0, 'low' => 0, 'total' => count($findings)];

        foreach ($findings as $finding) {
            $severity = (string)$finding->severity;
            if (isset($summary[$severity])) {
                $summary[$severity]++;
            }

            $payload[] = [
                'id' => (int)$finding->id,
                'type' => $finding->type,
                'severity' => $finding->severity,
                'title' => $finding->title,
                'description' => $finding->description,
                'recommendation' => $finding->recommendation,
                'evidence' => $finding->getJsonArray('evidence_json'),
            ];
        }

        $request = new LlmReportRequestDto(
            (string)($domain?->host ?? 'unknown'),
            (int)$run->pages_scanned,
            $payload,
            [
                'Проверяются только публичные HTML-страницы.',
                'JavaScript-контент может быть проверен неполно.',
                'Формы не отправляются.',
                'Отчёт не является юридической, SEO или security-гарантией.',
            ],
        );

        try {
            $rawResponse = $this->llmClient->generateAuditReport($request);
            $response = $this->validator->validate([
                'summary' => $rawResponse->summary,
                'tasks' => $rawResponse->tasks,
            ], $request, $rawResponse->model, $rawResponse->promptVersion, $rawResponse->inputTokens, $rawResponse->outputTokens);
        } catch (\Throwable $e) {
            $this->logLlmFailure($run, $request, $e);
            throw $e;
        }

        $report = Report::findOne(['audit_run_id' => $run->id]) ?? new Report(['audit_run_id' => $run->id]);
        $report->status = Report::STATUS_DRAFT;
        $report->summary_json = array_merge($summary, [
            'text' => $response->summary,
            'limitations' => $request->limitations,
        ]);
        $report->llm_model = $response->model;
        $report->prompt_version = $response->promptVersion;
        $report->touchUpdatedAt();

        if (!$report->save()) {
            throw new \RuntimeException('Не удалось сохранить отчёт: ' . json_encode($report->errors, JSON_UNESCAPED_UNICODE));
        }

        ReportTask::deleteAll(['report_id' => $report->id]);
        foreach ($response->tasks as $task) {
            $reportTask = new ReportTask([
                'report_id' => $report->id,
                'finding_id' => $task['findingId'] ?? null,
                'priority' => $task['priority'] ?? ReportTask::PRIORITY_LOW,
                'title' => $task['title'] ?? 'Проверить проблему сайта',
                'technical_description' => $task['technicalDescription'] ?? '',
                'business_reason' => $task['businessReason'] ?? null,
                'suggested_action' => $task['suggestedAction'] ?? 'Проверить finding.',
                'status' => ReportTask::STATUS_OPEN,
            ]);

            if (!$reportTask->save()) {
                throw new \RuntimeException('Не удалось сохранить задачу отчёта: ' . json_encode($reportTask->errors, JSON_UNESCAPED_UNICODE));
            }
        }

        $this->logService->logSuccess($run, $report, $this->llmClient, $request, $response);

        return $report;
    }

    /**
     * Пытается сохранить failed LLM log без сырого prompt/API response.
     *
     * @param AuditRun $run Запуск аудита.
     * @param LlmReportRequestDto $request Нормализованный request.
     * @param \Throwable $exception Ошибка LLM.
     * @return void
     */
    private function logLlmFailure(AuditRun $run, LlmReportRequestDto $request, \Throwable $exception): void
    {
        try {
            $this->logService->logFailure($run, $this->llmClient, $request, $exception);
        } catch (\Throwable $logException) {
            \Yii::error([
                'message' => 'Failed to save LLM failure log.',
                'auditRunId' => $run->id,
                'error' => $logException->getMessage(),
            ], __METHOD__);
        }
    }
}
