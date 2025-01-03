<?php

namespace frontend\controllers;

use common\components\Ping;
use frontend\components\controllers\parents\FrontendController;

/**
 * < Frontend > `PingController`
 *
 * @package yii2\frontend\controllers
 *
 * @tag #frontend #controller #ping
 */
class PingController extends FrontendController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return new Ping()->run();
    }
}