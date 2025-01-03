<?php

namespace common\components\base\actions;

use Yii;
use yii\web\Response;
use common\components\enums\Action;
use common\components\system\Notify;
use common\components\base\handlers\items\BaseWebHandler;
use common\components\base\resources\crud\BaseFormResource;
use common\components\base\resources\items\BaseTemplateResource;

/**
 * Class CrudAction
 *
 * @package yii2\common\components\base\actions
 */
abstract class CrudAction extends yii\base\Action
{
    public const string MESSAGE_SUCCESS = 'ОК';
    public const string MESSAGE_ERROR = 'Ошибка';
    public const string MESSAGE_NOT_FOUND = 'Элемент не найден';



    /** @var BaseWebHandler $handler */
    public BaseWebHandler $handler;

    /** @var BaseFormResource $resource */
    public BaseFormResource $resource;



    /**
     * @param $message
     * @param $template
     *
     * @return bool
     */
    public function setFlashMessage( $message, $template ): bool
    {
        return Notify::send( $message, $template );
    }

    /**
     * @return Response
     */
    public function goIndex(): Response
    {
        return Yii::$app->controller->redirect([Action::INDEX]);
    }


    /**
     * @param \common\components\base\resources\items\BaseTemplateResource $R
     *
     * @return string
     */
    protected function renderResource( BaseTemplateResource $R ): string
    {
        return Yii::$app->controller->view->render( $R->template, $R->release() );
    }
}