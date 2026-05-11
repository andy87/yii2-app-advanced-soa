<?php

namespace yii2\backend\components;

use Yii;
use yii2\common\components\Action;
use yii2\backend\controllers\AuditController;
use yii2\common\models\Identity;
use yii2\frontend\components\Site;

/**
 * Формирует элементы верхней навигации backend-приложения.
 *
 * @package yii2\backend\components
 */
class Header extends \yii2\common\components\Header
{
    /**
     * Возвращает элементы главного меню с учётом прав текущего пользователя.
     *
     * @return array
     */
    public static function getNavigationItems(): array
    {
        $items = [
            [
                'label' => Site::LABELS[Action::INDEX],
                'url' => '/'
            ],
        ];

        if (self::isCurrentUserAdmin()) {
            $items[] = [
                'label' => 'Аудиты',
                'url' => [AuditController::constructUrl()]
            ];
        }

        return $items;
    }

    /**
     * Проверяет, является ли текущий backend-пользователь администратором.
     *
     * @return bool True, если пользователь авторизован и имеет роль администратора.
     */
    private static function isCurrentUserAdmin(): bool
    {
        $identity = Yii::$app->user->identity;

        return $identity instanceof Identity && $identity->isAdmin();
    }
}
