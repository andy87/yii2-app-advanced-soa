<?php declare(strict_types=1);

namespace yii2\common\domains\user;

use andy87\yii2dnk\domain\BaseKiller;

/**
 * DNK killer домена User.
 *
 * Зарезервирован под hard-delete или soft-delete User.
 */
class UserKiller extends BaseKiller
{
    protected const DOMAIN = UserDomain::class;
}
