<?php declare(strict_types=1);

namespace yii2\common\models\audit;

use yii\db\ActiveQuery;

/**
 * Просканированная страница сайта с нормализованными SEO и структурными данными.
 *
 * @property int $id
 * @property int $audit_run_id
 * @property string $url
 * @property string $normalized_url
 * @property int|null $http_status
 * @property string|null $content_type
 * @property string|null $title
 * @property string|null $description
 * @property string|null $canonical
 * @property string|array $h1_json
 * @property string|array $links_json
 * @property string|array $forms_json
 * @property string|array $schema_json
 * @property string|null $fetched_at
 * @property string $created_at
 *
 * @package yii2\common\models\audit
 */
class AuditPage extends BaseAuditModel
{
    /**
     * Возвращает имя таблицы модели.
     *
     * @return string Имя таблицы.
     */
    public static function tableName(): string
    {
        return '{{%audit_pages}}';
    }

    /**
     * Возвращает правила валидации страницы аудита.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            [['audit_run_id', 'url', 'normalized_url'], 'required'],
            [['audit_run_id', 'http_status'], 'integer'],
            [['url', 'normalized_url', 'title', 'description', 'canonical'], 'string'],
            [['h1_json', 'links_json', 'forms_json', 'schema_json', 'fetched_at'], 'safe'],
            [['content_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * Возвращает список JSON-атрибутов модели.
     *
     * @return string[] Имена JSON-атрибутов.
     */
    protected function jsonAttributes(): array
    {
        return ['h1_json', 'links_json', 'forms_json', 'schema_json'];
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
     * Возвращает связь с findings страницы.
     *
     * @return ActiveQuery Связь с findings.
     */
    public function getFindings(): ActiveQuery
    {
        return $this->hasMany(Finding::class, ['page_id' => 'id']);
    }
}
