<?php declare(strict_types=1);

namespace app\backend\components\controllers;

use Yii;
use app\backend\controllers\{ SiteController, AuthController };
use app\common\components\{ Layout, Action, controllers\BaseWebController };

/**
 * < Backend > `BaseBackendController`
 *
 * @package app\backend\components\controllers
 *
 * @tag #backend #components #controller #base
 */
abstract class BaseBackendController extends BaseWebController
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
            'items' => $this->setupLayoutNavItems(),
        ];
    }

    /**
     * @return array
     */
    protected function setupLayoutNavItems(): array
    {
        return [
            [
                'label' => SiteController::LABELS[Action::INDEX],
                'url' => [SiteController::getEndpoint(Action::INDEX)]
            ],
        ];
    }
}