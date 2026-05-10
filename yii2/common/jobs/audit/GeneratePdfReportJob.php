<?php declare(strict_types=1);

namespace yii2\common\jobs\audit;

use yii\queue\JobInterface;
use yii\queue\Queue;
use yii2\common\models\audit\Report;
use yii2\common\services\audit\AuditRunnerService;

/**
 * Job генерации PDF отчёта.
 *
 * @package yii2\common\jobs\audit
 */
final class GeneratePdfReportJob implements JobInterface
{
    public int $reportId;

    /**
     * Генерирует PDF и ставит finalize job.
     *
     * @param Queue $queue Очередь Yii2.
     * @return void
     * @throws \RuntimeException Если отчёт не найден.
     */
    public function execute($queue): void
    {
        $report = Report::findOne($this->reportId);
        if ($report === null) {
            throw new \RuntimeException('Отчёт не найден.');
        }

        $service = new AuditRunnerService();
        try {
            $service->generatePdf($report);
            $queue->push(new FinalizeAuditRunJob(['auditRunId' => (int)$report->audit_run_id]));
        } catch (\Throwable $e) {
            if ($report->run !== null) {
                $service->fail($report->run, $e);
            }
            throw $e;
        }
    }

    /**
     * Создаёт job.
     *
     * @param array $config Конфигурация job.
     * @return void
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $name => $value) {
            $this->{$name} = $value;
        }
    }
}
