<?php

namespace yii2\common\components\actions\web;

use Throwable;
use yii\web\Response;
use yii\base\InvalidConfigException;
use yii2\common\components\system\Notify;
use yii2\common\components\base\actions\CrudAction;
use yii2\common\components\base\handlers\items\BaseWebHandler;

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
    /** @var string */
    public const string MESSAGE_SUCCESS = 'Удаление прошло успешно.';

    /** @var string */
    public const string MESSAGE_ERROR = 'Ошибка удаления записи.';



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
            $this->setFlashMessage( static::MESSAGE_SUCCESS, Notify::SUCCESS );

        } else {

            $this->setFlashMessage( static::MESSAGE_ERROR, Notify::ERROR );
        }

        return $this->goIndex();
    }
}