<?php declare(strict_types=1);

namespace yii2\common\jobs\audit;

use yii\queue\JobInterface;
use yii\queue\Queue;
use yii2\common\models\audit\Report;

/**
 * Job перехода от HTML-отчёта к PDF-генерации.
 *
 * @package yii2\common\jobs\audit
 */
final class RenderHtmlReportJob implements JobInterface
{
    public int $reportId;

    /**
     * Ставит PDF job.
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

        $queue->push(new GeneratePdfReportJob(['reportId' => (int)$report->id]));
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
