<?php declare(strict_types=1);

namespace yii2\common\components\core;

use yii\web\Controller;
use yii2\common\components\traits\Logger;

/**
 * < Common > `BaseController`
 *
 * @package yii2\common\components\core
 */
abstract class BaseWebController extends Controller
{
    use Logger;
}