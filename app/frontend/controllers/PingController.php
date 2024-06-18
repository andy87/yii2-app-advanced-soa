<?php

namespace app\frontend\controllers;

use app\common\components\Ping;
use app\backend\components\controllers\BaseBackendController;

/**
 * < Frontend > `PingController`
 *
 * @package app\frontend\controllers
 *
 * @tag #frontend #controller #ping
 */
class PingController extends BaseBackendController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return (new Ping())->run();
    }
}