<?php

namespace app\common\components\core;

use app\common\components\traits\Logger;
use yii\web\Controller;

/**
 * < Common > `BaseController`
 *
 * @package app\common\components\core
 */
abstract class BaseController extends Controller
{
    use Logger;
}