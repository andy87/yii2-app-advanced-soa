<?php declare(strict_types=1);

namespace yii2\common\domains\user;

use andy87\yii2dnk\domain\BaseProducer;

/**
 * DNK producer домена User.
 *
 * Отвечает за будущие сценарии создания User-моделей.
 */
class UserProducer extends BaseProducer
{
    protected const DOMAIN = UserDomain::class;
}
