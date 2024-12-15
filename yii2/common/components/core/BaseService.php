<?php declare(strict_types=1);

namespace yii2\common\components\core;

use yii2\common\components\traits\Logger;

/**
 * < Common > `BaseService`
 *
 * @package yii2\common\components\core
 */
abstract class BaseService extends BaseSingleton
{
    use Logger;
}