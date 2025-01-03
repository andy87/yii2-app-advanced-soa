<?php

namespace common\components\actions\web;

use common\components\base\actions\CrudAction;
use common\components\base\handlers\items\BaseWebHandler;
use common\components\base\models\items\sources\SourceModel;
use common\components\base\resources\crud\BaseCrudViewResource;
use common\components\system\Notify;
use yii\base\InvalidConfigException;
use yii\web\Response;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 * @property BaseCrudViewResource $resource
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

        $this->setFlashMessage(static::MESSAGE_NOT_FOUND, Notify::ERROR );

        return $this->goIndex();
    }
}