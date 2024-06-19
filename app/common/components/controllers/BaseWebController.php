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
    public const ENDPOINT = '/';

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

    /**
     * @param ?string $action
     *
     * @return string
     *
     * @tag #get #endpoint
     */
    public static function getEndpoint( ?string $action = null): string
    {
        $endpoint = static::ENDPOINT;

        if ($action) {
            $endpoint .= '/' . $action;
        }

        return $endpoint;
    }
}