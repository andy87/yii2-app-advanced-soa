<?php

namespace yii2\frontend\controllers;

use yii2\common\components\Ping;
use yii2\frontend\components\controllers\parents\FrontendController;

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
        return (new Ping())->run();
    }
}