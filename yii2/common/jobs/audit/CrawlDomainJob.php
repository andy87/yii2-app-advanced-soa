<?php declare(strict_types=1);

namespace yii2\common\jobs\audit;

use yii\queue\JobInterface;
use yii\queue\Queue;
use yii2\common\models\audit\AuditRun;
use yii2\common\services\audit\AuditRunnerService;

/**
 * Job обхода домена crawler.
 *
 * @package yii2\common\jobs\audit
 */
final class CrawlDomainJob implements JobInterface
{
    public int $auditRunId;

    /**
     * Выполняет crawl и ставит job проверок.
     *
     * @param Queue $queue Очередь Yii2.
     * @return void
     * @throws \RuntimeException Если запуск аудита не найден.
     */
    public function execute($queue): void
    {
        $run = AuditRun::findOne($this->auditRunId);
        if ($run === null) {
            throw new \RuntimeException('Запуск аудита не найден.');
        }

        $service = new AuditRunnerService();
        try {
            $service->crawl($run);
            $queue->push(new RunChecksJob(['auditRunId' => (int)$run->id]));
        } catch (\Throwable $e) {
            $service->fail($run, $e);
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
