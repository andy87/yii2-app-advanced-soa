<?php

namespace yii2\common\components\actions\web;

use Yii;
use yii\db\Exception;
use yii\web\Response;
use yii2\common\components\system\Notify;
use yii2\common\components\base\actions\CrudAction;
use yii2\common\components\base\handlers\items\BaseWebHandler;
use yii2\common\components\base\resources\crud\BaseFormResource;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 * @property BaseFormResource $resource;
 *
 * @package app\common\components\actions\crud
 *
 * @tag: #common #default #crud #action #index
 */
class CrudUpdateAction extends CrudAction
{
    public const MESSAGE_SUCCESS = 'Запись успешно обновлена.';
    public const MESSAGE_ERROR = 'Ошибка обновления записи.';



    /**
     * @param int $id
     *
     * @return Response|string
     *
     * @throws Exception|\Exception
     */
    public function run( int $id ): Response|string
    {
        $params = (Yii::$app->request->isPost) ? (array) Yii::$app->request->bodyParams : [];

        $R = $this->handler->processUpdateForm( $id, $params );

        if ( count($params) )
        {
            if ( $R->form->save() )
            {
                $this->setFlashMessage(self::MESSAGE_SUCCESS, Notify::SUCCESS );

            } else {

                $this->setFlashMessage(self::MESSAGE_ERROR, Notify::ERROR );
            }

        } elseif ( $R->form === null ) {

            $this->setFlashMessage(self::MESSAGE_NOT_FOUND, Notify::ERROR );

            return $this->goIndex();
        }

        return $this->renderResource( $R );
    }
}