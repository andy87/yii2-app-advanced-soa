<?php

namespace frontend\components;

use yii\base\BaseObject;
use common\components\enums\Action;
use frontend\controllers\SiteController;

/**
 *
 */
class Navigation extends BaseObject
{
    public const string INDEX = Action::INDEX;
    public const string CONTACT = SiteController::ACTION_CONTACT;

    public const string ABOUT = SiteController::ACTION_ABOUT;


    public const array TITLES = [
        Action::INDEX => 'Главная',
        self::ABOUT => 'О нас',
        self::CONTACT => 'Контакты',
    ];
}