<?php declare(strict_types=1);

namespace yii2\common\domains\identity;

use andy87\yii2dnk\BasePayload;
use andy87\yii2dnk\domain\BaseHandler;
use andy87\yii2dnk\viewModels\BaseViewModel;

/**
 * DNK handler домена Identity.
 *
 * Заготовка registry-слоя; конкретные Identity use-case будут добавлены отдельной миграцией.
 */
class IdentityHandler extends BaseHandler
{
    protected const DOMAIN = IdentityDomain::class;

    /**
     * Обрабатывает payload домена Identity.
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
