<?php

namespace yii2\common\components;

use Yii;
use yii2\frontend\components\Site;
use yii2\frontend\controllers\AuthController;
use yii2\frontend\controllers\SiteController;

/**
 *
 */
class Header
{
    public const BUTTON_TEXT_LOGIN = 'Войти';
    public const BUTTON_TEXT_LOGOUT = 'Выйти';

    /**
     * @return array
     */
    public static function getNavigationItems(): array
    {
        $menuItems = [
            [
                'label' => Site::LABELS[Action::INDEX],
                'url' => '/'
            ],
            [
                'label' => Site::LABELS[Site::ACTION_ABOUT],
                'url' => [SiteController::getEndpoint(Site::ACTION_ABOUT)]
            ],
            [
                'label' => Site::LABELS[Site::ACTION_CONTACT],
                'url' => [SiteController::getEndpoint(Site::ACTION_CONTACT)]
            ],
        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => Auth::LABELS[Auth::ACTION_SIGNUP],
                'url' => [AuthController::getEndpoint(Auth::ACTION_SIGNUP)]
            ];
        }

        return $menuItems;
    }
}