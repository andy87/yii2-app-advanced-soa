<?php declare(strict_types=1);

namespace yii2\common\services\audit;

use yii2\common\models\audit\AuditOrder;
use yii2\common\models\audit\Domain;
use yii2\common\services\audit\crawler\DomainSafetyValidator;
use yii2\common\services\audit\crawler\UrlNormalizer;
use yii2\common\services\audit\dto\AuditOrderRequestDto;

/**
 * Сервис создания и управления заказами аудита.
 *
 * @package yii2\common\services\audit
 */
final class AuditOrderService
{
    /**
     * Создаёт сервис заказов аудита.
     *
     * @param UrlNormalizer $normalizer Нормализатор URL.
     * @param DomainSafetyValidator $safetyValidator SSRF-защита.
     * @return void
     */
    public function __construct(
        private readonly UrlNormalizer $normalizer = new UrlNormalizer(),
        private readonly DomainSafetyValidator $safetyValidator = new DomainSafetyValidator(),
    ) {
    }

    /**
     * Создаёт заказ аудита и домен при необходимости.
     *
     * @param AuditOrderRequestDto $dto DTO входных данных.
     * @return AuditOrder Созданный заказ.
     * @throws \Throwable При ошибке транзакции, URL или сохранения.
     */
    public function createOrder(AuditOrderRequestDto $dto): AuditOrder
    {
        $normalizedUrl = $this->normalizer->normalizeStartUrl($dto->domainUrl);
        $this->safetyValidator->assertSafeUrl($normalizedUrl);
        $host = $this->normalizer->host($normalizedUrl);
        $limit = max(1, min($dto->pageLimit, (int)($_ENV['AUDIT_MAX_PAGE_LIMIT'] ?? 100)));

        return \Yii::$app->db->transaction(function () use ($dto, $host, $normalizedUrl, $limit): AuditOrder {
            $domain = Domain::findOne(['user_id' => $dto->userId, 'host' => $host]) ?? new Domain([
                'user_id' => $dto->userId,
                'host' => $host,
            ]);

            $domain->normalized_url = $normalizedUrl;
            $domain->status = Domain::STATUS_ACTIVE;
            $domain->touchUpdatedAt();

            if (!$domain->save()) {
                throw new \RuntimeException('Не удалось сохранить домен: ' . json_encode($domain->errors, JSON_UNESCAPED_UNICODE));
            }

            $order = new AuditOrder([
                'user_id' => $dto->userId,
                'domain_id' => $domain->id,
                'tariff' => $dto->tariff,
                'payment_status' => AuditOrder::PAYMENT_UNPAID,
                'workflow_status' => AuditOrder::WORKFLOW_NEW,
                'page_limit' => $limit,
                'notes' => $dto->notes,
            ]);

            if (!$order->save()) {
                throw new \RuntimeException('Не удалось сохранить заказ: ' . json_encode($order->errors, JSON_UNESCAPED_UNICODE));
            }

            return $order;
        });
    }

    /**
     * Меняет статус оплаты заказа.
     *
     * @param AuditOrder $order Заказ аудита.
     * @param string $paymentStatus Новый статус оплаты.
     * @return AuditOrder Обновлённый заказ.
     * @throws \RuntimeException Если статус не удалось сохранить.
     */
    public function changePaymentStatus(AuditOrder $order, string $paymentStatus): AuditOrder
    {
        $order->payment_status = $paymentStatus;
        if ($paymentStatus === AuditOrder::PAYMENT_PAID && $order->workflow_status === AuditOrder::WORKFLOW_NEW) {
            $order->workflow_status = AuditOrder::WORKFLOW_READY_TO_RUN;
        }
        $order->touchUpdatedAt();

        if (!$order->save()) {
            throw new \RuntimeException('Не удалось изменить статус оплаты: ' . json_encode($order->errors, JSON_UNESCAPED_UNICODE));
        }

        return $order;
    }
}
