<?php declare(strict_types=1);

namespace yii2\common\models\audit;

use yii\db\ActiveQuery;

/**
 * Детерминированная проблема, найденная правилами аудита.
 *
 * @property int $id
 * @property int $audit_run_id
 * @property int|null $page_id
 * @property string $type
 * @property string $severity
 * @property string $title
 * @property string $description
 * @property string|array $evidence_json
 * @property string|null $recommendation
 * @property bool $is_false_positive
 * @property string $created_at
 * @property string $updated_at
 *
 * @package yii2\common\models\audit
 */
class Finding extends BaseAuditModel
{
    public const SEVERITY_CRITICAL = 'critical';
    public const SEVERITY_MEDIUM = 'medium';
    public const SEVERITY_LOW = 'low';

    /**
     * Возвращает имя таблицы модели.
     *
     * @return string Имя таблицы.
     */
    public static function tableName(): string
    {
        return '{{%findings}}';
    }

    /**
     * Возвращает правила валидации finding.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            [['audit_run_id', 'type', 'severity', 'title', 'description'], 'required'],
            [['audit_run_id', 'page_id'], 'integer'],
            [['title', 'description', 'recommendation'], 'string'],
            [['evidence_json'], 'safe'],
            [['is_false_positive'], 'boolean'],
            [['type'], 'string', 'max' => 64],
            [['severity'], 'in', 'range' => [self::SEVERITY_CRITICAL, self::SEVERITY_MEDIUM, self::SEVERITY_LOW]],
        ];
    }

    /**
     * Возвращает список JSON-атрибутов модели.
     *
     * @return string[] Имена JSON-атрибутов.
     */
    protected function jsonAttributes(): array
    {
        return ['evidence_json'];
    }

    /**
     * Возвращает связь с запуском аудита.
     *
     * @return ActiveQuery Связь с запуском.
     */
    public function getRun(): ActiveQuery
    {
        return $this->hasOne(AuditRun::class, ['id' => 'audit_run_id']);
    }

    /**
     * Возвращает связь со страницей finding.
     *
     * @return ActiveQuery Связь со страницей.
     */
    public function getPage(): ActiveQuery
    {
        return $this->hasOne(AuditPage::class, ['id' => 'page_id']);
    }
}
