<?php

namespace common\components\actions\web;

use Yii;
use yii\base\InvalidConfigException;
use common\components\base\actions\CrudAction;
use common\components\base\handlers\items\BaseWebHandler;
use common\components\base\resources\crud\BaseGridViewResource;
use common\components\base\resources\crud\BaseListViewResource;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 * @property BaseGridViewResource|BaseListViewResource $resource
 *
 * @package yii2\common\components\actions\crud
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