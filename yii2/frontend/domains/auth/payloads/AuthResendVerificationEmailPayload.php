<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth\payloads;

use andy87\yii2dnk\BasePayload;

/**
 * DNK payload действия auth/resend-verification-email.
 *
 * Хранит transport-вход формы повторной отправки письма подтверждения.
 */
class AuthResendVerificationEmailPayload extends BasePayload
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
