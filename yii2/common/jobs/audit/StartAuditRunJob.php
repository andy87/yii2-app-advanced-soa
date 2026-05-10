<?php declare(strict_types=1);

namespace yii2\common\jobs\audit;

use yii\queue\JobInterface;
use yii\queue\Queue;
use yii2\common\models\audit\AuditOrder;
use yii2\common\services\audit\AuditRunnerService;

/**
 * Job создания AuditRun и постановки crawler job.
 *
 * @package yii2\common\jobs\audit
 */
final class StartAuditRunJob implements JobInterface
{
    public int $orderId;

    /**
     * Выполняет создание запуска аудита.
     *
     * @param Queue $queue Очередь Yii2.
     * @return void
     * @throws \RuntimeException Если заказ не найден.
     */
    public function execute($queue): void
    {
        $order = AuditOrder::findOne($this->orderId);
        if ($order === null) {
            throw new \RuntimeException('Заказ аудита не найден.');
        }

        $run = (new AuditRunnerService())->createRun($order);
        $queue->push(new CrawlDomainJob(['auditRunId' => (int)$run->id]));
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
