<?php

namespace yii2\common\components\actions\web;

use Yii;
use yii\db\Exception;
use yii\base\InvalidConfigException;
use yii2\common\components\system\Notify;
use yii2\common\components\base\actions\CrudAction;
use yii2\common\components\base\handlers\items\BaseWebHandler;
use yii2\common\components\base\resources\crud\BaseFormResource;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 * @property BaseFormResource $resource
 *
 * @package app\common\components\actions\crud
 *
 * @tag: #common #default #crud #action #index
 */
class CrudCreateAction extends CrudAction
{
    /** @var string */
    public const string MESSAGE_SUCCESS = 'Запись успешно создана.';

    /** @var string */
    public const string MESSAGE_ERROR = 'Ошибка создания записи.';



    /**
     * @return string
     *
     * @throws InvalidConfigException|\Exception|Exception
     */
    public function run(): string
    {
        $params = (Yii::$app->request->isPost) ? (array) Yii::$app->request->bodyParams : [];

        $R = $this->handler->processCreateForm( $params );

        if ( count($params) )
        {
            ( isset($R->form->id) )
                ? $this->setFlashMessage(static::MESSAGE_SUCCESS, Notify::SUCCESS )
                : $this->setFlashMessage(static::MESSAGE_ERROR, Notify::ERROR );
        }

        return $this->renderResource( $R );
    }
}