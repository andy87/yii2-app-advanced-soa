<?php

namespace yii2\backend\controllers;

use yii2\common\components\Ping;
use yii2\backend\components\controllers\parents\BackendController;

/**
 * < Backend > `PingController`
 *
 * @package yii2\backend\controllers
 *
 * @tag #backend #controller #ping
 */
class PingController extends BackendController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return (new Ping)->run();
    }
}