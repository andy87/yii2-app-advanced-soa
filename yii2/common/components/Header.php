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
        return [];
    }
}