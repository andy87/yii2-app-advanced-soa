<?php declare(strict_types=1);

namespace yii2\common\models\audit;

use yii\db\ActiveQuery;
use yii2\common\models\Identity;

/**
 * Отчёт по запуску аудита с путями к HTML/PDF и статусом human review.
 *
 * @property int $id
 * @property int $audit_run_id
 * @property string $status
 * @property string|null $html_path
 * @property string|null $pdf_path
 * @property string|array $summary_json
 * @property string|null $llm_model
 * @property string|null $prompt_version
 * @property int|null $approved_by_admin_id
 * @property string|null $approved_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @package yii2\common\models\audit
 */
class Report extends BaseAuditModel
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_SENT = 'sent';

    /**
     * Возвращает имя таблицы модели.
     *
     * @return string Имя таблицы.
     */
    public static function tableName(): string
    {
        return '{{%reports}}';
    }

    /**
     * Возвращает правила валидации отчёта.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            [['audit_run_id', 'status'], 'required'],
            [['audit_run_id', 'approved_by_admin_id'], 'integer'],
            [['html_path', 'pdf_path'], 'string'],
            [['summary_json', 'approved_at'], 'safe'],
            [['status'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_APPROVED, self::STATUS_SENT]],
            [['llm_model'], 'string', 'max' => 128],
            [['prompt_version'], 'string', 'max' => 64],
        ];
    }

    /**
     * Возвращает список JSON-атрибутов модели.
     *
     * @return string[] Имена JSON-атрибутов.
     */
    protected function jsonAttributes(): array
    {
        return ['summary_json'];
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
     * Возвращает связь с задачами отчёта.
     *
     * @return ActiveQuery Связь с задачами.
     */
    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(ReportTask::class, ['report_id' => 'id']);
    }

    /**
     * Возвращает связь с администратором, утвердившим отчёт.
     *
     * @return ActiveQuery Связь с администратором.
     */
    public function getApprovedByAdmin(): ActiveQuery
    {
        return $this->hasOne(Identity::class, ['id' => 'approved_by_admin_id']);
    }
}
