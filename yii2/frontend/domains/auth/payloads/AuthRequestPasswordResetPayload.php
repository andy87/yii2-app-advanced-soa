<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth\payloads;

use andy87\yii2dnk\BasePayload;

/**
 * DNK payload действия auth/request-password-reset.
 *
 * Хранит transport-вход формы запроса письма сброса пароля.
 */
class AuthRequestPasswordResetPayload extends BasePayload
{
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
            ['isPost', 'boolean'],
            ['formData', 'safe'],
        ];
    }
}
