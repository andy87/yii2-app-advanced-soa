<?php declare(strict_types=1);

namespace yii2\common\models\audit;

use yii\db\ActiveQuery;

/**
 * Запуск аудита конкретного заказа с техническим статусом обработки.
 *
 * @property int $id
 * @property int $order_id
 * @property string $status
 * @property string|null $started_at
 * @property string|null $finished_at
 * @property int $page_limit
 * @property int $pages_scanned
 * @property string|null $error_message
 * @property string|array $crawler_config_json
 * @property string $created_at
 * @property string $updated_at
 *
 * @package yii2\common\models\audit
 */
class AuditRun extends BaseAuditModel
{
    public const STATUS_QUEUED = 'queued';
    public const STATUS_CRAWLING = 'crawling';
    public const STATUS_CHECKING = 'checking';
    public const STATUS_REPORTING = 'reporting';
    public const STATUS_PDF = 'pdf';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    /**
     * Возвращает имя таблицы модели.
     *
     * @return string Имя таблицы.
     */
    public static function tableName(): string
    {
        return '{{%audit_runs}}';
    }

    /**
     * Возвращает правила валидации запуска аудита.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            [['order_id', 'status', 'page_limit'], 'required'],
            [['order_id', 'page_limit', 'pages_scanned'], 'integer'],
            [['started_at', 'finished_at', 'created_at', 'updated_at'], 'safe'],
            [['error_message'], 'string'],
            [['crawler_config_json'], 'safe'],
            [['status'], 'string', 'max' => 32],
        ];
    }

    /**
     * Возвращает список JSON-атрибутов модели.
     *
     * @return string[] Имена JSON-атрибутов.
     */
    protected function jsonAttributes(): array
    {
        return ['crawler_config_json'];
    }

    /**
     * Возвращает связь с заказом.
     *
     * @return ActiveQuery Связь с заказом.
     */
    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(AuditOrder::class, ['id' => 'order_id']);
    }

    /**
     * Возвращает связь со страницами запуска.
     *
     * @return ActiveQuery Связь со страницами.
     */
    public function getPages(): ActiveQuery
    {
        return $this->hasMany(AuditPage::class, ['audit_run_id' => 'id']);
    }

    /**
     * Возвращает связь с findings запуска.
     *
     * @return ActiveQuery Связь с findings.
     */
    public function getFindings(): ActiveQuery
    {
        return $this->hasMany(Finding::class, ['audit_run_id' => 'id']);
    }

    /**
     * Возвращает связь с отчётом запуска.
     *
     * @return ActiveQuery Связь с отчётом.
     */
    public function getReport(): ActiveQuery
    {
        return $this->hasOne(Report::class, ['audit_run_id' => 'id']);
    }
}
