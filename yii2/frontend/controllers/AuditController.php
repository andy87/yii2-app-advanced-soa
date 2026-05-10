<?php declare(strict_types=1);

namespace yii2\frontend\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii2\common\models\audit\AuditOrder;
use yii2\common\models\audit\Report;
use yii2\common\services\audit\AuditOrderService;
use yii2\common\services\audit\dto\AuditOrderRequestDto;
use yii2\frontend\components\controllers\BaseFrontendController;

/**
 * Клиентский контроллер кабинета аудитов.
 *
 * @package yii2\frontend\controllers
 */
final class AuditController extends BaseFrontendController
{
    public const ENDPOINT = 'audit';

    /**
     * Показывает список заказов текущего клиента.
     *
     * @return Response|string Ответ redirect или HTML.
     */
    public function actionIndex(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/auth/login']);
        }

        $orders = AuditOrder::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with(['domain', 'runs.report'])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', ['orders' => $orders]);
    }

    /**
     * Создаёт заказ аудита.
     *
     * @return Response|string Ответ redirect или HTML формы.
     * @throws \Throwable При ошибке создания заказа.
     */
    public function actionCreate(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/auth/login']);
        }

        $error = null;
        if (Yii::$app->request->isPost) {
            try {
                $order = (new AuditOrderService())->createOrder(new AuditOrderRequestDto(
                    (int)Yii::$app->user->id,
                    (string)Yii::$app->request->post('domain'),
                    (string)Yii::$app->request->post('tariff', AuditOrder::TARIFF_EXPRESS),
                    (int)Yii::$app->request->post('page_limit', (int)($_ENV['AUDIT_DEFAULT_PAGE_LIMIT'] ?? 20)),
                    (string)Yii::$app->request->post('notes', ''),
                ));

                return $this->redirect(['view', 'id' => $order->id]);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
            }
        }

        return $this->render('create', ['error' => $error]);
    }

    /**
     * Показывает карточку заказа клиента.
     *
     * @param int $id Идентификатор заказа.
     * @return string HTML карточки.
     * @throws NotFoundHttpException Если заказ не найден.
     * @throws ForbiddenHttpException Если заказ принадлежит другому пользователю.
     */
    public function actionView(int $id): string
    {
        $order = $this->findOrder($id);

        return $this->render('view', ['order' => $order]);
    }

    /**
     * Показывает HTML-отчёт в кабинете клиента.
     *
     * @param int $id Идентификатор отчёта.
     * @return string HTML отчёта.
     * @throws NotFoundHttpException Если отчёт не найден.
     * @throws ForbiddenHttpException Если отчёт принадлежит другому пользователю.
     */
    public function actionReport(int $id): string
    {
        $report = $this->findReport($id);

        return $this->render('report', ['report' => $report]);
    }

    /**
     * Отдаёт PDF-отчёт после проверки прав доступа.
     *
     * @param int $id Идентификатор отчёта.
     * @return Response PDF-файл.
     * @throws NotFoundHttpException Если отчёт или файл не найден.
     * @throws ForbiddenHttpException Если отчёт принадлежит другому пользователю.
     */
    public function actionDownload(int $id): Response
    {
        $report = $this->findReport($id);
        if ($report->pdf_path === null || !is_file($report->pdf_path)) {
            throw new NotFoundHttpException('PDF-отчёт ещё не сформирован.');
        }

        return Yii::$app->response->sendFile($report->pdf_path, 'audit-report-' . $report->id . '.pdf');
    }

    /**
     * Находит заказ и проверяет ownership.
     *
     * @param int $id Идентификатор заказа.
     * @return AuditOrder Заказ.
     * @throws NotFoundHttpException Если заказ не найден.
     * @throws ForbiddenHttpException Если заказ принадлежит другому пользователю.
     */
    private function findOrder(int $id): AuditOrder
    {
        $order = AuditOrder::find()->with(['domain', 'runs.report'])->where(['id' => $id])->one();
        if (!$order instanceof AuditOrder) {
            throw new NotFoundHttpException('Заказ не найден.');
        }

        if ((int)$order->user_id !== (int)Yii::$app->user->id) {
            throw new ForbiddenHttpException('Нет доступа к заказу.');
        }

        return $order;
    }

    /**
     * Находит отчёт и проверяет ownership.
     *
     * @param int $id Идентификатор отчёта.
     * @return Report Отчёт.
     * @throws NotFoundHttpException Если отчёт не найден.
     * @throws ForbiddenHttpException Если отчёт принадлежит другому пользователю.
     */
    private function findReport(int $id): Report
    {
        $report = Report::find()->with(['run.order.domain', 'tasks'])->where(['id' => $id])->one();
        if (!$report instanceof Report || $report->run === null || $report->run->order === null) {
            throw new NotFoundHttpException('Отчёт не найден.');
        }

        if ((int)$report->run->order->user_id !== (int)Yii::$app->user->id) {
            throw new ForbiddenHttpException('Нет доступа к отчёту.');
        }

        return $report;
    }
}
