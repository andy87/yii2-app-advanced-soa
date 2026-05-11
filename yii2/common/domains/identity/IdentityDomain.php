<?php declare(strict_types=1);

namespace yii2\common\domains\identity;

use andy87\yii2dnk\domain\BaseDomain;
use yii2\common\models\Identity;

/**
 * DNK registry домена Identity.
 *
 * Фиксирует пакетную структуру слоя Identity для последующей миграции legacy-сервисов.
 */
class IdentityDomain extends BaseDomain
{
    protected string $model = Identity::class;

    protected string $service = IdentityService::class;

    protected string $repository = IdentityRepository::class;

    protected string $producer = IdentityProducer::class;

    protected string $killer = IdentityKiller::class;

    protected string $handler = IdentityHandler::class;
}
