<?php declare(strict_types=1);

namespace yii2\common\domains\identity;

use andy87\yii2dnk\domain\BaseKiller;

/**
 * DNK killer домена Identity.
 *
 * Зарезервирован под сценарии удаления или soft-delete Identity.
 */
class IdentityKiller extends BaseKiller
{
    protected const DOMAIN = IdentityDomain::class;
}
