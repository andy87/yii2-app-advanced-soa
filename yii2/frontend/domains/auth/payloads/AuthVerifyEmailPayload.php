<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth\payloads;

use andy87\yii2dnk\BasePayload;

/**
 * DNK payload действия auth/verify-email.
 *
 * Валидирует наличие verification token.
 */
class AuthVerifyEmailPayload extends BasePayload
{
    public string $token = '';

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
        ];
    }
}
