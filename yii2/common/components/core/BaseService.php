<?php declare(strict_types=1);

namespace yii2\common\components\core;

use yii\base\BaseObject;
use yii2\common\components\traits\Logger;
use yii2\common\components\interfaces\core\ServiceInterface;

/**
 * < Common > `BaseService`
 *
 * @package yii2\common\components\core
 */
abstract class BaseService extends BaseObject implements ServiceInterface
{
    use Logger;
}