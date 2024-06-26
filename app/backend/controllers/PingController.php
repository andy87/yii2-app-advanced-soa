<?php

namespace app\backend\controllers;

use app\common\components\Ping;
use app\backend\components\controllers\BaseBackendController;

/**
 * < Backend > `PingController`
 *
 * @package app\backend\controllers
 *
 * @tag #backend #controller #ping
 */
class PingController extends BaseBackendController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return (new Ping)->run();
    }
}