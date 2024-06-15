<?php declare(strict_types=1);

namespace app\common\components\core;

use app\common\components\traits\Logger;

/**
 * < Common > `BaseService`
 *
 * @package app\common\components\core
 */
abstract class BaseService extends BaseSingleton
{
    use Logger;
}