<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth;

use andy87\yii2dnk\domain\BaseProducer;

/**
 * DNK producer домена авторизации.
 *
 * Зарезервирован для создания auth-моделей и форм в следующих шагах миграции.
 */
class AuthProducer extends BaseProducer
{
    protected const DOMAIN = AuthDomain::class;
}
