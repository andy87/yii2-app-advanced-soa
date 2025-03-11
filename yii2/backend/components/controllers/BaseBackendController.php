<?php declare(strict_types=1);

namespace yii2\backend\components\controllers;

use Yii;
use yii2\backend\components\Header;
use yii2\common\components\Layout;
use yii2\common\components\controllers\BaseWebWebController;

/**
 * < Backend > `BaseBackendController`
 *
 * @package yii2\backend\components\controllers
 *
 * @tag #backend #components #controller #base
 */
abstract class BaseBackendController extends BaseWebWebController
{
    /**
     * @return void
     */
    protected function setupLayoutNavBarConfig(): void
    {
        Layout::$navBarConfig = [
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => Layout::$class['navBar'],
            ],
        ];
    }

    /**
     * @return void
     */
    protected function setupLayoutNavConfig(): void
    {
        Layout::$navConfig = [
            'options' => ['class' => Layout::$class['nav']],
            'items' => Header::getNavigationItems(),
        ];
    }
}