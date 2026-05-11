<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth\payloads;

use andy87\yii2dnk\BasePayload;

/**
 * DNK payload действия auth/reset-password.
 *
 * Валидирует наличие token и переносит POST-данные формы нового пароля.
 */
class AuthResetPasswordPayload extends BasePayload
{
    public string $token = '';

    public bool $isPost = false;

    /** @var array<string, mixed> */
    public array $formData = [];

    /**
     * Возвращает правила валидации payload.
     *
     * @return array<int, mixed> Правила Yii Model.
     */
    public function rules(): array
    {
        return [
            ['token', 'required'],
            ['token', 'string'],
            ['isPost', 'boolean'],
            ['formData', 'safe'],
        ];
    }
}
