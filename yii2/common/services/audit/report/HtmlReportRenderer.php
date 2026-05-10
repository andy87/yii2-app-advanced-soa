<?php declare(strict_types=1);

namespace yii2\common\services\audit\report;

use yii\helpers\Html;
use yii2\common\models\audit\Finding;
use yii2\common\models\audit\Report;

/**
 * Рендерит самостоятельный HTML-файл отчёта.
 *
 * @package yii2\common\services\audit\report
 */
final class HtmlReportRenderer
{
    /**
     * Создаёт HTML-файл отчёта и возвращает путь.
     *
     * @param Report $report Отчёт.
     * @return string Абсолютный путь к HTML-файлу.
     * @throws \RuntimeException Если файл не удалось записать.
     */
    public function render(Report $report): string
    {
        $run = $report->run;
        $order = $run?->order;
        $domain = $order?->domain;
        $summary = $report->getJsonArray('summary_json');
        $tasks = $report->tasks;
        $findings = Finding::find()->where(['audit_run_id' => $run?->id])->with('page')->all();

        $dir = \Yii::getAlias('@uploads/reports/' . (int)$report->id);
        if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new \RuntimeException('Не удалось создать директорию отчёта.');
        }

        $html = $this->document($domain?->host ?? 'unknown', $summary, $tasks, $findings, (int)($run?->pages_scanned ?? 0));
        $path = $dir . '/report.html';
        if (file_put_contents($path, $html) === false) {
            throw new \RuntimeException('Не удалось записать HTML-отчёт.');
        }

        $report->html_path = $path;
        $report->touchUpdatedAt();
        $report->save(false);

        return $path;
    }

    /**
     * Собирает HTML-документ отчёта.
     *
     * @param string $domain Домен отчёта.
     * @param array $summary Summary отчёта.
     * @param array $tasks Задачи отчёта.
     * @param array $findings Findings отчёта.
     * @param int $pagesScanned Количество страниц.
     * @return string HTML-документ.
     */
    private function document(string $domain, array $summary, array $tasks, array $findings, int $pagesScanned): string
    {
        $taskHtml = '';
        foreach ($tasks as $task) {
            $taskHtml .= '<article class="b_report--task">'
                . '<h3 class="b_report--subtitle">' . Html::encode($task->title) . '</h3>'
                . '<p class="b_report--text"><strong>Приоритет:</strong> ' . Html::encode($task->priority) . '</p>'
                . '<p class="b_report--text">' . Html::encode($task->business_reason ?? '') . '</p>'
                . '<p class="b_report--text"><strong>Что сделать:</strong> ' . Html::encode($task->suggested_action) . '</p>'
                . '</article>';
        }

        $findingRows = '';
        foreach ($findings as $finding) {
            $findingRows .= '<tr class="b_report--row">'
                . '<td class="b_report--cell">' . Html::encode($finding->severity) . '</td>'
                . '<td class="b_report--cell">' . Html::encode($finding->type) . '</td>'
                . '<td class="b_report--cell">' . Html::encode($finding->page?->url ?? 'site-wide') . '</td>'
                . '<td class="b_report--cell">' . Html::encode($finding->title) . '</td>'
                . '</tr>';
        }

        return '<!doctype html><html lang="ru"><head><meta charset="utf-8"><title>Отчёт аудита ' . Html::encode($domain) . '</title>'
            . '<style>body{font-family:Arial,sans-serif;color:#1f2937;margin:32px}.block__report{max-width:1040px;margin:0 auto}.b_report--title{font-size:30px}.b_report--summary{background:#f3f4f6;padding:16px;border-radius:8px}.b_report--task{border:1px solid #d1d5db;border-radius:8px;padding:14px;margin:12px 0}.b_report--table{width:100%;border-collapse:collapse}.b_report--cell,.b_report--head{border:1px solid #d1d5db;padding:8px;text-align:left;vertical-align:top}.b_report--notice{color:#6b7280}</style>'
            . '</head><body><section class="block__report"><h1 class="b_report--title">Аудит сайта ' . Html::encode($domain) . '</h1>'
            . '<div class="b_report--summary"><p class="b_report--text">' . Html::encode((string)($summary['text'] ?? '')) . '</p>'
            . '<p class="b_report--text">Просканировано страниц: ' . $pagesScanned . '. Критичных: ' . (int)($summary['critical'] ?? 0) . ', средних: ' . (int)($summary['medium'] ?? 0) . ', низких: ' . (int)($summary['low'] ?? 0) . '.</p></div>'
            . '<h2 class="b_report--header">Приоритетные задачи</h2>' . $taskHtml
            . '<h2 class="b_report--header">Технические findings</h2><table class="b_report--table"><thead><tr><th class="b_report--head">Severity</th><th class="b_report--head">Type</th><th class="b_report--head">URL</th><th class="b_report--head">Finding</th></tr></thead><tbody>' . $findingRows . '</tbody></table>'
            . '<p class="b_report--notice">Ограничения: проверяются только публичные страницы; формы не отправляются; отчёт не является юридической, SEO или security-гарантией; AI-рекомендации требуют проверки человеком.</p>'
            . '</section></body></html>';
    }
}
