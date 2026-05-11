<?php declare(strict_types=1);

namespace yii2\common\domains\identity;

use andy87\yii2dnk\domain\BaseService;

/**
 * DNK service домена Identity.
 *
 * Пока содержит только registry-совместимый слой для будущей миграции операций Identity.
 */
class IdentityService extends BaseService
{
    protected const DOMAIN = IdentityDomain::class;
}
