<?php declare(strict_types=1);

namespace yii2\common\models\audit;

use yii\db\ActiveQuery;
use yii2\common\models\Identity;

/**
 * Заказ на аудит сайта с ручным статусом оплаты и workflow-статусом выполнения.
 *
 * @property int $id
 * @property int $user_id
 * @property int $domain_id
 * @property string $tariff
 * @property string $payment_status
 * @property string $workflow_status
 * @property int $page_limit
 * @property string|null $notes
 * @property string $created_at
 * @property string $updated_at
 *
 * @package yii2\common\models\audit
 */
class AuditOrder extends BaseAuditModel
{
    public const TARIFF_EXPRESS = 'express';
    public const TARIFF_FULL = 'full';
    public const TARIFF_IMPLEMENTATION = 'implementation';

    public const PAYMENT_UNPAID = 'unpaid';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_REFUNDED = 'refunded';
    public const PAYMENT_CANCELLED = 'cancelled';

    public const WORKFLOW_NEW = 'new';
    public const WORKFLOW_READY_TO_RUN = 'ready_to_run';
    public const WORKFLOW_RUNNING = 'running';
    public const WORKFLOW_REPORT_REVIEW = 'report_review';
    public const WORKFLOW_COMPLETED = 'completed';
    public const WORKFLOW_FAILED = 'failed';
    public const WORKFLOW_CANCELLED = 'cancelled';

    /**
     * Возвращает имя таблицы модели.
     *
     * @return string Имя таблицы.
     */
    public static function tableName(): string
    {
        return '{{%audit_orders}}';
    }

    /**
     * Возвращает правила валидации заказа.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            [['user_id', 'domain_id', 'tariff', 'page_limit'], 'required'],
            [['user_id', 'domain_id', 'page_limit'], 'integer'],
            [['notes'], 'string'],
            [['tariff', 'payment_status', 'workflow_status'], 'string', 'max' => 32],
            [['tariff'], 'in', 'range' => [self::TARIFF_EXPRESS, self::TARIFF_FULL, self::TARIFF_IMPLEMENTATION]],
            [['payment_status'], 'in', 'range' => [self::PAYMENT_UNPAID, self::PAYMENT_PAID, self::PAYMENT_REFUNDED, self::PAYMENT_CANCELLED]],
            [['workflow_status'], 'in', 'range' => [self::WORKFLOW_NEW, self::WORKFLOW_READY_TO_RUN, self::WORKFLOW_RUNNING, self::WORKFLOW_REPORT_REVIEW, self::WORKFLOW_COMPLETED, self::WORKFLOW_FAILED, self::WORKFLOW_CANCELLED]],
        ];
    }

    /**
     * Возвращает связь с владельцем заказа.
     *
     * @return ActiveQuery Связь с пользователем.
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Identity::class, ['id' => 'user_id']);
    }

    /**
     * Возвращает связь с доменом заказа.
     *
     * @return ActiveQuery Связь с доменом.
     */
    public function getDomain(): ActiveQuery
    {
        return $this->hasOne(Domain::class, ['id' => 'domain_id']);
    }

    /**
     * Возвращает связь с запусками аудита.
     *
     * @return ActiveQuery Связь с запусками.
     */
    public function getRuns(): ActiveQuery
    {
        return $this->hasMany(AuditRun::class, ['order_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }
}
