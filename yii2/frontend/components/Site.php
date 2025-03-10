<?php

namespace yii2\frontend\components;

use yii2\common\components\Action;

class Site
{
    public const ACTION_CONTACT = 'contact';
    public const ACTION_ABOUT = 'about';

    public const LABELS = [
        Action::INDEX => 'Главная',
        self::ACTION_ABOUT => 'О нас',
        self::ACTION_CONTACT => 'Контакты',
    ];
}