<?php declare(strict_types=1);

namespace app\frontend\components\controllers;

use app\common\components\core\BaseWebController;
use yii\web\ErrorAction;

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