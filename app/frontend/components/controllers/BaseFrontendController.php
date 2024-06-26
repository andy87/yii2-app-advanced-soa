<?php declare(strict_types=1);

namespace app\frontend\components\controllers;

use Yii;
use app\frontend\controllers\{ SiteController, AuthController };
use app\common\components\{ Layout, Action, controllers\BaseWebController };

/**
 * < Frontend > `BaseFrontendController`
 *
 * @package app\frontend\components
 *
 * @tag #components #controllers #frontend
 */
abstract class BaseFrontendController extends BaseWebController
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
        $menuItems = [
            [
                'label' => SiteController::LABELS[Action::INDEX],
                'url' => [SiteController::getEndpoint(Action::INDEX)]
            ],
            [
                'label' => SiteController::LABELS[SiteController::ACTION_ABOUT],
                'url' => [SiteController::getEndpoint(SiteController::ACTION_ABOUT)]
            ],
            [
                'label' => SiteController::LABELS[SiteController::ACTION_CONTACT],
                'url' => [SiteController::getEndpoint(SiteController::ACTION_CONTACT)]
            ],
        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => AuthController::LABELS[AuthController::ACTION_SIGNUP],
                'url' => [AuthController::getEndpoint(AuthController::ACTION_SIGNUP)]
            ];
        }

        return $menuItems;
    }
}