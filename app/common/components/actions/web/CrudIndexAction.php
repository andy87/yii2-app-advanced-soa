<?php

namespace app\common\components\actions\web;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\base\actions\CrudAction;
use app\common\components\base\handlers\items\BaseWebHandler;
use app\common\components\base\services\resources\crud\BaseGridViewResource;
use app\common\components\base\services\resources\crud\BaseListViewResource;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 * @property BaseGridViewResource|BaseListViewResource $resource
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