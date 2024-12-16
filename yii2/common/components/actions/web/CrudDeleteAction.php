<?php

namespace yii2\common\components\actions\web;

use yii2\common\components\base\actions\CrudAction;
use yii2\common\components\base\handlers\items\BaseWebHandler;
use yii2\common\components\system\Notify;
use Throwable;
use yii\base\InvalidConfigException;
use yii\web\Response;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 *
 * @package app\common\components\actions\crud
 *
 * @tag: #common #default #crud #action #index
 */
class CrudDeleteAction extends CrudAction
{
    public const MESSAGE_SUCCESS = 'Удаление прошло успешно.';
    public const MESSAGE_ERROR = 'Ошибка удаления записи.';



    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws InvalidConfigException|Throwable
     */
    public function run( int $id ): Response
    {
        $result = $this->handler->processDelete($id);

        if ( $result )
        {
            $this->setFlashMessage( self::MESSAGE_SUCCESS, Notify::SUCCESS );

        } else {

            $this->setFlashMessage( self::MESSAGE_ERROR, Notify::ERROR );
        }

        return $this->goIndex();
    }
}