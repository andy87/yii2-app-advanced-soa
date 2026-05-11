<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth\viewModels;

use andy87\yii2dnk\viewModels\BaseTemplateResource;
use yii2\frontend\models\forms\PasswordResetRequestForm;

/**
 * DNK view-model действия auth/request-password-reset.
 *
 * Формирует данные для legacy view `@app/views/auth/request-password-reset-token`.
 */
class AuthRequestPasswordResetViewModel extends BaseTemplateResource
{
    public const TEMPLATE = '@app/views/auth/request-password-reset-token';

    public PasswordResetRequestForm $passwordResetRequestForm;

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
