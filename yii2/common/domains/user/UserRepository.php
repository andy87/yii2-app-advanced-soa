<?php declare(strict_types=1);

namespace yii2\common\domains\user;

use andy87\yii2dnk\domain\BaseRepository;

/**
 * DNK repository домена User.
 *
 * Инкапсулирует чтение User ActiveRecord в новом пакетном DNK runtime.
 */
class UserRepository extends BaseRepository
{
    protected const DOMAIN = UserDomain::class;
}
