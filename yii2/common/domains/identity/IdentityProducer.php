<?php declare(strict_types=1);

namespace yii2\common\domains\identity;

use andy87\yii2dnk\domain\BaseProducer;

/**
 * DNK producer домена Identity.
 *
 * Отвечает за будущие сценарии создания Identity через пакетный DNK runtime.
 */
class IdentityProducer extends BaseProducer
{
    protected const DOMAIN = IdentityDomain::class;
}
