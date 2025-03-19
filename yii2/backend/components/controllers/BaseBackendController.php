<?php declare(strict_types=1);

namespace yii2\backend\components\controllers;

use Yii;
use yii2\backend\components\Header;
use yii2\common\components\Layout;

/**
 * < Backend > `BaseBackendController`
 *
 * @package yii2\backend\components\controllers
 *
 * @tag #backend #components #controller #base
 */
abstract class BaseBackendController extends \yii2\common\components\core\controllers\BaseWebController
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