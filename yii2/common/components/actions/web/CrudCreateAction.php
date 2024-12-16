<?php

namespace yii2\common\components\actions\web;

use yii2\common\components\base\actions\CrudAction;
use yii2\common\components\base\handlers\items\BaseWebHandler;
use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\resources\crud\BaseFormResource;
use yii2\common\components\system\Notify;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;

/**
 * Class CrudIndexAction
 *
 * @property \yii2\common\components\base\handlers\items\BaseWebHandler $handler
 * @property BaseFormResource $resource
 *
 * @package app\common\components\actions\crud
 *
 * @tag: #common #default #crud #action #index
 */
class CrudCreateAction extends CrudAction
{
    public const MESSAGE_SUCCESS = 'Запись успешно создана.';
    public const MESSAGE_ERROR = 'Ошибка создания записи.';



    /**
     * @return string
     *
     * @throws InvalidConfigException|\Exception|Exception
     */
    public function run(): string
    {
        $params = (Yii::$app->request->isPost) ? (array) Yii::$app->request->bodyParams : [];

        $R = $this->handler->processCreateForm( $params);

        if ( count($params) )
        {
            if ( $R->form->isNewRecord )
            {
                $this->setFlashMessage('Ошибка создания записи.', Notify::ERROR );

            } else {

                $this->setFlashMessage('Запись успешно создана.', Notify::SUCCESS );
            }
        }

        return $this->renderResource( $R );
    }
}