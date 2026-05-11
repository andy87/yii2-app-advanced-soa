<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth;

use andy87\yii2dnk\domain\BaseKiller;

/**
 * DNK killer домена авторизации.
 *
 * В login/reset-password сценариях не используется, но требуется registry-контрактом BaseDomain.
 */
class AuthKiller extends BaseKiller
{
    protected const DOMAIN = AuthDomain::class;
}
