<?php

namespace app\common\components\core;

use app\common\components\traits\RuntimeLogs;
use yii\web\Controller;

/**
 * Class `BaseController`
 *
 * @package app\common\components\core
 */
abstract class BaseController extends Controller
{
    use RuntimeLogs;
}