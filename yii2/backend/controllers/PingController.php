<?php

namespace backend\controllers;

use backend\services\items\PascalCaseService;
use yii\filters\AccessControl;
use backend\components\controllers\parents\BackendController;

/**
 * < Backend > `PingController`
 *
 * @package yii2\backend\controllers
 *
 * @tag #backend #controller #ping
 */
class PingController extends BackendController
{
    private readonly PascalCaseService $service;

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['?'], //user
                ],
            ],
        ];

        return $behaviors;
    }

    public function __construct(PascalCaseService $service, $id, $module, $config = [])
    {
        $this->service = $service;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     */
    public function actionTest(): array
    {
        $object = $this->service->test();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $object;
    }
}