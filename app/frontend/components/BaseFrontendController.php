<?php

namespace app\frontend\components;

use yii\web\ErrorAction;
use app\common\components\core\BaseWebController;

/**
 *  Class `BaseFrontendController`
 *
 * @package app\frontend\components
 */
class BaseFrontendController extends BaseWebController
{
    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'view' => 'views/errors/common'
            ]
        ];
    }
}