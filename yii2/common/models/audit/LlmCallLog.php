<?php declare(strict_types=1);

namespace yii2\common\models\audit;

use yii\db\ActiveQuery;

/**
 * Технический лог LLM-вызова без хранения полного сырого prompt по умолчанию.
 *
 * @property int $id
 * @property int|null $audit_run_id
 * @property int|null $report_id
 * @property string $provider
 * @property string $model
 * @property string $prompt_version
 * @property string $request_hash
 * @property string|null $response_hash
 * @property int|null $http_status
 * @property int|null $input_tokens
 * @property int|null $output_tokens
 * @property string $status
 * @property string|null $error_message
 * @property string $created_at
 *
 * @package yii2\common\models\audit
 */
class LlmCallLog extends BaseAuditModel
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';

    /**
     * Возвращает имя таблицы модели.
     *
     * @return string Имя таблицы.
     */
    public static function tableName(): string
    {
        return '{{%llm_call_logs}}';
    }

    /**
     * Возвращает правила валидации LLM-лога.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            [['provider', 'model', 'prompt_version', 'request_hash', 'status'], 'required'],
            [['audit_run_id', 'report_id', 'http_status', 'input_tokens', 'output_tokens'], 'integer'],
            [['error_message'], 'string'],
            [['provider', 'prompt_version'], 'string', 'max' => 64],
            [['model', 'request_hash', 'response_hash'], 'string', 'max' => 128],
            [['status'], 'in', 'range' => [self::STATUS_SUCCESS, self::STATUS_FAILED]],
        ];
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
     * Возвращает связь с отчётом.
     *
     * @return ActiveQuery Связь с отчётом.
     */
    public function getReport(): ActiveQuery
    {
        return $this->hasOne(Report::class, ['id' => 'report_id']);
    }
}
