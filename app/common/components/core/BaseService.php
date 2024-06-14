<?php

namespace app\common\components\core;

use app\common\components\traits\RuntimeLogs;

/**
 * Class `BaseService`
 *
 * @package app\common\components\core
 */
abstract class BaseService extends BaseSingleton
{
    use RuntimeLogs;
}