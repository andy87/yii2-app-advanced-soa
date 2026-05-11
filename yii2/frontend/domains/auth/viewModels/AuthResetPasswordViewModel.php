<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth\viewModels;

use andy87\yii2dnk\viewModels\BaseTemplateResource;
use yii2\frontend\models\forms\ResetPasswordForm;

/**
 * DNK view-model действия auth/reset-password.
 *
 * Формирует данные для legacy view `@app/views/auth/reset-password`.
 */
class AuthResetPasswordViewModel extends BaseTemplateResource
{
    public const TEMPLATE = '@app/views/auth/reset-password';

    public ResetPasswordForm $resetPasswordForm;

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
