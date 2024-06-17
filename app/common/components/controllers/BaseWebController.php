<?php declare(strict_types=1);

namespace app\common\components\controllers;

use yii\web\ErrorAction;
use app\common\components\core\BaseController;

/**
 * < Common > `BaseWebController`
 *
 * @package app\common\components\core
 */
abstract class BaseWebController extends BaseController
{
    public const ACTION_INDEX = 'index';
    public const ACTION_ERROR = 'error';

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'view' => '@app/views/system/error'
            ]
        ];
    }
}