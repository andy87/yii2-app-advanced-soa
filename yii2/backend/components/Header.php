<?php

namespace yii2\backend\components;

use yii2\common\components\Action;
use yii2\frontend\components\Site;

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
        return [
            [
                'label' => Site::LABELS[Action::INDEX],
                'url' => '/'
            ],
        ];
    }
}