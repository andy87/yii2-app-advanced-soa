<?php declare(strict_types=1);

namespace yii2\console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;
use yii2\common\jobs\audit\StartAuditRunJob;
use yii2\common\models\audit\AuditOrder;
use yii2\common\services\audit\AuditRunnerService;

/**
 * Консольное управление аудитами и локальный fallback без worker.
 *
 * @package yii2\console\controllers
 */
final class AuditController extends Controller
{
    /**
     * Ставит заказ аудита в Redis Queue.
     *
     * @param int $orderId Идентификатор заказа.
     * @return int Код завершения.
     * @throws \RuntimeException Если заказ не найден.
     */
    public function actionQueue(int $orderId): int
    {
        if (AuditOrder::findOne($orderId) === null) {
            $this->stderr("Заказ #{$orderId} не найден.\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }

        \Yii::$app->queue->push(new StartAuditRunJob(['orderId' => $orderId]));
        $this->stdout("Заказ #{$orderId} поставлен в очередь.\n");

        return ExitCode::OK;
    }

    /**
     * Синхронно выполняет полный pipeline заказа без Redis worker.
     *
     * @param int $orderId Идентификатор заказа.
     * @return int Код завершения.
     */
    public function actionRunNow(int $orderId): int
    {
        $order = AuditOrder::findOne($orderId);
        if ($order === null) {
            $this->stderr("Заказ #{$orderId} не найден.\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $service = new AuditRunnerService();
        $run = $service->createRun($order);

        try {
            $service->crawl($run);
            $service->runChecks($run);
            $report = $service->generateReport($run);
            $service->generatePdf($report);
            $service->finalize($run);
        } catch (\Throwable $e) {
            $service->fail($run, $e);
            $this->stderr($e->getMessage() . "\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout("Аудит #{$run->id} завершён.\n");

        return ExitCode::OK;
    }
}
