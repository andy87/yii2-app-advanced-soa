<?php declare(strict_types=1);

namespace app\common\components\core;

use yii\web\Controller;
use app\common\components\traits\Logger;

/**
 * < Common > `BaseController`
 *
 * @package app\common\components\core
 */
abstract class BaseController extends Controller
{
    use Logger;
}