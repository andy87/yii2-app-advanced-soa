<?php declare(strict_types=1);

namespace yii2\common\components\core\controllers;

use yii\console\Controller;
use yii2\common\components\traits\Logger;

/**
 * < Common > `BaseController`
 *
 * @package yii2\common\components\core
 */
abstract class BaseConsoleController extends Controller
{
    use Logger;
}