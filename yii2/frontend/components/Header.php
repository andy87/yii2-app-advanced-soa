<?php

namespace yii2\frontend\components;

use Yii;
use yii2\common\components\Action;
use yii2\common\components\Auth;
use yii2\frontend\controllers\AuthController;
use yii2\frontend\controllers\SiteController;

/**
 *
 */
class Header extends \yii2\common\components\Header
{
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
                'url' => [SiteController::constructUrl(Site::ACTION_ABOUT)]
            ],
            [
                'label' => Site::LABELS[Site::ACTION_CONTACT],
                'url' => [SiteController::constructUrl(Site::ACTION_CONTACT)]
            ],
        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => Auth::LABELS[Auth::ACTION_SIGNUP],
                'url' => [AuthController::constructUrl(Auth::ACTION_SIGNUP)]
            ];
        }

        return $menuItems;
    }
}