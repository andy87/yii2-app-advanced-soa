<?php declare(strict_types=1);

namespace yii2\common\components\core\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * < Common > `BaseWebController`
 *
 * @package yii2\common\components\core
 */
abstract class BaseWebController extends Controller
{
    public const ENDPOINT = '/';


    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setupLayoutNavBarConfig();
        $this->setupLayoutNavConfig();
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'view' => '@common/views/system/error'
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
    public static function constructUrl(?string $action = null): string
    {
        $endpoint = static::ENDPOINT;

        if ($action === null ) $action = '';

        return "/$endpoint/$action";
    }



    protected function setupLayoutNavBarConfig()
    {

    }

    protected function setupLayoutNavConfig()
    {

    }
}