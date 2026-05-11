<?php declare(strict_types=1);

namespace yii2\common\domains\user;

use andy87\yii2dnk\domain\BaseService;

/**
 * DNK service домена User.
 *
 * Содержит будущие бизнес-операции User CRUD поверх пакетного DNK runtime.
 */
class UserService extends BaseService
{
    protected const DOMAIN = UserDomain::class;
}
