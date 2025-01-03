<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use common\components\AccessControl;
use backend\services\items\PascalCaseService;
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
                    'roles' => [AccessControl::ROLE_USER],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @param PascalCaseService $service
     * @param $id
     * @param $module
     * @param array $config
     *
     * @return void
     */
    public function __construct(PascalCaseService $service, $id, $module, array $config = [])
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

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $object;
    }
}