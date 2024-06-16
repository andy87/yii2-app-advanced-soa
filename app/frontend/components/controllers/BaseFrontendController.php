<?php declare(strict_types=1);

namespace app\frontend\components\controllers;

use yii\web\ErrorAction;
use app\common\components\core\BaseWebController;

/**
 * < Frontend > `BaseFrontendController`
 *
 * @package app\frontend\components
 *
 * @tag #components #controllers #frontend
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