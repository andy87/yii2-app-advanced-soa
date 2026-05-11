<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth\viewModels;

use andy87\yii2dnk\viewModels\BaseTemplateResource;
use yii2\common\models\forms\LoginForm;

/**
 * DNK view-model действия auth/login.
 *
 * Формирует данные для legacy view `@app/views/auth/login`.
 */
class AuthLoginViewModel extends BaseTemplateResource
{
    public const TEMPLATE = '@app/views/auth/login';

    public LoginForm $loginForm;

    /**
     * Инициализирует форму входа.
     *
     * @param array<string, mixed> $config Конфигурация Yii object.
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->loginForm = new LoginForm();
    }

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
