<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth\payloads;

use andy87\yii2dnk\BasePayload;

/**
 * DNK payload действия auth/login.
 *
 * Хранит только transport-вход: признак POST и массив данных формы Yii ActiveForm.
 */
class AuthLoginPayload extends BasePayload
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
