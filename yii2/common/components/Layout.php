<?php

namespace yii2\common\components;

use Yii;
use yii\helpers\Html;
use yii2\backend\controllers\AuthController;

/**
 * < Common >
 *
 * @package yii2\common\components
 *
 * @since 1.0
 *
 * @tag #view #helper #layout
 */
class Layout
{
    public const META_VIEWPORT = 'viewport';

    /** @var array|array[] */
    public static array $meta = [
        self::META_VIEWPORT => [
            'name' => 'viewport',
            'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no'
        ]
    ];

    public static array $class = [
        'html' => 'h-100',
        'body' => 'd-flex flex-column h-100',
        'main' => 'flex-shrink-0',
        'footer' => 'footer mt-auto py-3 text-muted',
        'navBar' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        'nav' => 'navbar-nav me-auto mb-2 mb-md-0',
    ];

    public static array $navBarConfig = [];
    public static array $navConfig = [];



    /**
     * @param $name
     *
     * @return string
     */
    public static function meta($name): string
    {
        return Html::tag('meta', null, self::$meta[$name]);
    }

    /**
     * @return string
     */
    public static function getHtmlAuthBlock(): string
    {
        return (Yii::$app->user->isGuest)
            ? Layout::getHtmlLoginButton()
            : Layout::getHtmlLogoutForm();
    }

    /**
     * @return string
     */
    public static function getHtmlLoginButton(): string
    {
        $link = Html::a(Header::BUTTON_TEXT_LOGIN,
            [AuthController::constructUrl(Action::LOGIN)],
            ['class' => ['btn btn-link login text-decoration-none']]
        );

        return Html::tag('div', $link,['class' => ['d-flex']]);
    }

    /**
     * @return string
     */
    public static function getHtmlLogoutForm(): string
    {
        return Html::beginForm([AuthController::constructUrl(Action::LOGOUT)], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                Header::BUTTON_TEXT_LOGOUT . ' (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }

    /**
     * @return string
     */
    public static function getHtmlCopyRight(): string
    {
        return Yii::t('yii', 'Powered by {yii}, (And_y87 edition)', [
            'yii' => '<a href="https://www.yiiframework.com/" rel="external">' . Yii::t('yii', 'Yii Framework') . '</a>',
        ]);
    }
}