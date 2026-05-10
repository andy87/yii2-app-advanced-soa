<?php declare(strict_types=1);

namespace yii2\backend\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii2\backend\components\controllers\BaseBackendController;
use yii2\common\jobs\audit\StartAuditRunJob;
use yii2\common\models\audit\AuditOrder;
use yii2\common\models\audit\Report;
use yii2\common\models\Identity;
use yii2\common\services\audit\AuditOrderService;

/**
 * Административный контроллер управления заказами и отчётами аудита.
 *
 * @package yii2\backend\controllers
 */
final class AuditController extends BaseBackendController
{
    public const ENDPOINT = 'audit';

    /**
     * Показывает список всех заказов аудита.
     *
     * @return string HTML списка.
     * @throws ForbiddenHttpException Если пользователь не администратор.
     */
    public function actionIndex(): string
    {
        $this->assertAdmin();
        $orders = AuditOrder::find()->with(['domain', 'user', 'runs.report'])->orderBy(['id' => SORT_DESC])->all();

        return $this->render('index', ['orders' => $orders]);
    }

    /**
     * Показывает карточку заказа.
     *
     * @param int $id Идентификатор заказа.
     * @return string HTML карточки.
     * @throws ForbiddenHttpException Если пользователь не администратор.
     * @throws NotFoundHttpException Если заказ не найден.
     */
    public function actionView(int $id): string
    {
        $this->assertAdmin();
        $order = $this->findOrder($id);

        return $this->render('view', ['order' => $order]);
    }

    /**
     * Переводит заказ в статус paid.
     *
     * @param int $id Идентификатор заказа.
     * @return Response Redirect к карточке заказа.
     * @throws ForbiddenHttpException Если пользователь не администратор.
     * @throws NotFoundHttpException Если заказ не найден.
     */
    public function actionMarkPaid(int $id): Response
    {
        $this->assertAdmin();
        $order = $this->findOrder($id);
        (new AuditOrderService())->changePaymentStatus($order, AuditOrder::PAYMENT_PAID);

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Ставит запуск аудита в очередь.
     *
     * @param int $id Идентификатор заказа.
     * @return Response Redirect к карточке заказа.
     * @throws ForbiddenHttpException Если пользователь не администратор.
     * @throws NotFoundHttpException Если заказ не найден.
     */
    public function actionRun(int $id): Response
    {
        $this->assertAdmin();
        $this->findOrder($id);
        Yii::$app->queue->push(new StartAuditRunJob(['orderId' => $id]));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Утверждает черновик отчёта.
     *
     * @param int $id Идентификатор отчёта.
     * @return Response Redirect к заказу.
     * @throws ForbiddenHttpException Если пользователь не администратор.
     * @throws NotFoundHttpException Если отчёт не найден.
     */
    public function actionApproveReport(int $id): Response
    {
        $this->assertAdmin();
        $report = Report::findOne($id);
        if ($report === null || $report->run === null) {
            throw new NotFoundHttpException('Отчёт не найден.');
        }

        $report->status = Report::STATUS_APPROVED;
        $report->approved_by_admin_id = (int)Yii::$app->user->id;
        $report->approved_at = date('Y-m-d H:i:s');
        $report->touchUpdatedAt();
        $report->save(false);

        return $this->redirect(['view', 'id' => $report->run->order_id]);
    }

    /**
     * Проверяет административный доступ.
     *
     * @return void
     * @throws ForbiddenHttpException Если пользователь не администратор.
     */
    private function assertAdmin(): void
    {
        $identity = Yii::$app->user->identity;
        if (!$identity instanceof Identity || !$identity->isAdmin()) {
            throw new ForbiddenHttpException('Доступ только для администратора.');
        }
    }

    /**
     * Находит заказ аудита.
     *
     * @param int $id Идентификатор заказа.
     * @return AuditOrder Заказ.
     * @throws NotFoundHttpException Если заказ не найден.
     */
    private function findOrder(int $id): AuditOrder
    {
        $order = AuditOrder::find()->with(['domain', 'user', 'runs.report'])->where(['id' => $id])->one();
        if (!$order instanceof AuditOrder) {
            throw new NotFoundHttpException('Заказ не найден.');
        }

        return $order;
    }
}
