<?php

namespace yii2\common\components\actions\web;

use Yii;
use yii\base\InvalidConfigException;
use yii2\common\components\base\actions\CrudAction;
use yii2\common\components\base\handlers\items\BaseWebHandler;
use yii2\common\components\base\resources\crud\BaseGridViewResource;
use yii2\common\components\base\resources\crud\BaseListViewResource;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 * @property \yii2\common\components\base\resources\crud\BaseGridViewResource|\yii2\common\components\base\resources\crud\BaseListViewResource $resource
 *
 * @package app\common\components\actions\crud
 *
 * @tag: #common #default #crud #action #index
 */
class CrudIndexAction extends CrudAction
{
    /**
     * @return string
     *
     * @throws InvalidConfigException
     */
    public function run(): string
    {
        $this->resource->searchModel = $this->handler->service->settings->classSearchModel;

        $this->resource->activeDataProvider = $this->handler->service->getDataProvider(Yii::$app->request->bodyParams);

        return $this->renderResource($this->resource);
    }
}