<?php declare(strict_types=1);

namespace yii2\frontend\components\controllers;

use Yii;
use yii2\common\components\{Layout};
use yii2\frontend\components\Header;

/**
 * < Frontend > `BaseFrontendController`
 *
 * @package yii2\frontend\components
 *
 * @tag #components #controllers #frontend
 */
abstract class BaseFrontendController extends \yii2\common\components\core\controllers\BaseWebController
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