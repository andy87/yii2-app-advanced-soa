<?php

namespace app\backend\components\controllers;

use app\common\components\core\BaseWebController;
use yii\web\ErrorAction;

/**
 * < Backend > `BaseBackendController`
 *
 * @package app\backend\components\controllers
 *
 * @tag #backend #components #controller #base
 */
abstract class BaseBackendController extends BaseWebController
{
    public const ACTION_INDEX = 'index';
    public const ACTION_ERROR = 'error';

    /**
     * {@inheritdoc}
     *
     * @return array
     *
     * @tag #backend #components #controller #actions
     */
    public function actions(): array
    {
        return [
            self::ACTION_ERROR => [
                'class' => ErrorAction::class,
                'view' => 'views/system/error',
            ],
        ];
    }
}