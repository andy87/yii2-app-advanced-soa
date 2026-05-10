<?php declare(strict_types=1);

namespace yii2\common\models\audit;

use yii\db\ActiveQuery;
use yii2\common\models\Identity;

/**
 * Домен сайта, который принадлежит пользователю и может участвовать в заказах аудита.
 *
 * @property int $id
 * @property int $user_id
 * @property string $host
 * @property string $normalized_url
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package yii2\common\models\audit
 */
class Domain extends BaseAuditModel
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';

    /**
     * Возвращает имя таблицы модели.
     *
     * @return string Имя таблицы.
     */
    public static function tableName(): string
    {
        return '{{%domains}}';
    }

    /**
     * Возвращает правила валидации домена.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            [['user_id', 'host', 'normalized_url'], 'required'],
            [['user_id'], 'integer'],
            [['host'], 'string', 'max' => 255],
            [['normalized_url'], 'string', 'max' => 2048],
            [['status'], 'string', 'max' => 32],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BLOCKED]],
        ];
    }

    /**
     * Возвращает связь с владельцем домена.
     *
     * @return ActiveQuery Связь с пользователем.
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Identity::class, ['id' => 'user_id']);
    }

    /**
     * Возвращает связь с заказами домена.
     *
     * @return ActiveQuery Связь с заказами.
     */
    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(AuditOrder::class, ['domain_id' => 'id']);
    }
}
