<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth\viewModels;

use andy87\yii2dnk\viewModels\BaseTemplateResource;
use yii2\frontend\models\forms\ResendVerificationEmailForm;

/**
 * DNK view-model действия auth/resend-verification-email.
 *
 * Формирует данные для legacy view `@app/views/auth/resend-verification-email`.
 */
class AuthResendVerificationEmailViewModel extends BaseTemplateResource
{
    public const TEMPLATE = '@app/views/auth/resend-verification-email';

    public ResendVerificationEmailForm $resendVerificationEmailForm;

    /**
     * Возвращает данные для render.
     *
     * @param array<string, mixed> $params Дополнительные параметры render.
     * @return array<string, mixed> Данные view.
     */
    public function release(array $params = []): array
    {
        return array_merge(['R' => $this], $params);
    }
}
