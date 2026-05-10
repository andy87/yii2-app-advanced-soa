<?php declare(strict_types=1);

namespace yii2\common\services\audit\report;

use Dompdf\Dompdf;
use yii2\common\models\audit\Report;

/**
 * Рендерит PDF-файл отчёта из HTML.
 *
 * @package yii2\common\services\audit\report
 */
final class PdfReportRenderer
{
    /**
     * Рендерит HTML отчёта в PDF и возвращает путь.
     *
     * @param Report $report Отчёт с html_path.
     * @return string Абсолютный путь к PDF-файлу.
     * @throws \RuntimeException Если HTML отсутствует или PDF не удалось записать.
     */
    public function render(Report $report): string
    {
        if ($report->html_path === null || !is_file($report->html_path)) {
            throw new \RuntimeException('HTML-отчёт не найден для PDF-экспорта.');
        }

        $html = file_get_contents($report->html_path);
        if ($html === false) {
            throw new \RuntimeException('Не удалось прочитать HTML-отчёт.');
        }

        $pdfPath = dirname($report->html_path) . '/report.pdf';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();

        if (file_put_contents($pdfPath, $dompdf->output()) === false) {
            throw new \RuntimeException('Не удалось записать PDF-отчёт.');
        }

        $report->pdf_path = $pdfPath;
        $report->touchUpdatedAt();
        $report->save(false);

        return $pdfPath;
    }
}
