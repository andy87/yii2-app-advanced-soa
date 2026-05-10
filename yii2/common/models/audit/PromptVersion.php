<?php declare(strict_types=1);

namespace yii2\common\models\audit;

/**
 * Версия prompt-шаблонов для LLM-части отчёта.
 *
 * @property int $id
 * @property string $code
 * @property string $system_prompt
 * @property string $user_prompt_template
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package yii2\common\models\audit
 */
class PromptVersion extends BaseAuditModel
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_ARCHIVED = 'archived';

    /**
     * Возвращает имя таблицы модели.
     *
     * @return string Имя таблицы.
     */
    public static function tableName(): string
    {
        return '{{%prompt_versions}}';
    }

    /**
     * Возвращает правила валидации prompt-версии.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            [['code', 'system_prompt', 'user_prompt_template', 'status'], 'required'],
            [['system_prompt', 'user_prompt_template'], 'string'],
            [['code'], 'string', 'max' => 64],
            [['code'], 'unique'],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_ARCHIVED]],
        ];
    }
}
