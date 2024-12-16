<?php

namespace yii2\common\components\actions\web;

use yii2\common\components\base\actions\CrudAction;
use yii2\common\components\base\handlers\items\BaseWebHandler;
use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\resources\crud\BaseCrudViewResource;
use yii2\common\components\system\Notify;
use yii\base\InvalidConfigException;
use yii\web\Response;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 * @property \yii2\common\components\base\resources\crud\BaseCrudViewResource $resource
 *
 * @package app\common\components\actions\crud
 *
 * @tag: #common #default #crud #action #index
 */
class CrudViewAction extends CrudAction
{
    /**
     * @param int $id
     *
     * @return Response|string
     *
     * @throws InvalidConfigException
     */
    public function run( int $id ): Response|string
    {
        $R = $this->handler->processViewForm( $id );

        if ( $R->model )
        {
            return $this->renderResource( $R );
        }

        $this->setFlashMessage(self::MESSAGE_NOT_FOUND, Notify::ERROR );

        return $this->goIndex();
    }
}