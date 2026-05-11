<?php declare(strict_types=1);

namespace yii2\common\domains\user;

use andy87\yii2dnk\BasePayload;
use andy87\yii2dnk\domain\BaseHandler;
use andy87\yii2dnk\viewModels\BaseViewModel;

/**
 * DNK handler домена User.
 *
 * Заготовка registry-слоя; конкретные User use-case будут добавлены отдельной миграцией.
 */
class UserHandler extends BaseHandler
{
    protected const DOMAIN = UserDomain::class;

    /**
     * Обрабатывает payload домена User.
     *
     * @param BasePayload $payload Входной payload.
     * @param BaseViewModel|null $viewModel View-model из registry.
     * @return BaseViewModel|bool|array|null Результат обработки.
     */
    protected function provider(BasePayload $payload, ?BaseViewModel $viewModel = null): BaseViewModel|bool|array|null
    {
        return $viewModel;
    }
}
