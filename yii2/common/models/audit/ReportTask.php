<?php declare(strict_types=1);

namespace yii2\common\models\audit;

use yii\db\ActiveQuery;

/**
 * Приоритизированная задача отчёта, понятная клиенту и разработчику.
 *
 * @property int $id
 * @property int $report_id
 * @property int|null $finding_id
 * @property string $priority
 * @property string $title
 * @property string $technical_description
 * @property string|null $business_reason
 * @property string $suggested_action
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package yii2\common\models\audit
 */
class ReportTask extends BaseAuditModel
{
    public const PRIORITY_CRITICAL = 'critical';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_LOW = 'low';

    public const STATUS_OPEN = 'open';
    public const STATUS_DONE = 'done';
    public const STATUS_FALSE_POSITIVE = 'false_positive';

    /**
     * Возвращает имя таблицы модели.
     *
     * @return string Имя таблицы.
     */
    public static function tableName(): string
    {
        return '{{%report_tasks}}';
    }

    /**
     * Возвращает правила валидации задачи отчёта.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            [['report_id', 'priority', 'title', 'technical_description', 'suggested_action'], 'required'],
            [['report_id', 'finding_id'], 'integer'],
            [['title', 'technical_description', 'business_reason', 'suggested_action'], 'string'],
            [['priority'], 'in', 'range' => [self::PRIORITY_CRITICAL, self::PRIORITY_MEDIUM, self::PRIORITY_LOW]],
            [['status'], 'in', 'range' => [self::STATUS_OPEN, self::STATUS_DONE, self::STATUS_FALSE_POSITIVE]],
        ];
    }

    /**
     * Возвращает связь с отчётом.
     *
     * @return ActiveQuery Связь с отчётом.
     */
    public function getReport(): ActiveQuery
    {
        return $this->hasOne(Report::class, ['id' => 'report_id']);
    }

    /**
     * Возвращает связь с исходным finding.
     *
     * @return ActiveQuery Связь с finding.
     */
    public function getFinding(): ActiveQuery
    {
        return $this->hasOne(Finding::class, ['id' => 'finding_id']);
    }
}
