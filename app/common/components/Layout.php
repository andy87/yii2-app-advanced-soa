<?php

namespace app\common\components;

use yii\helpers\Html;

/**
 * < Common >
 *
 * @package app\common\components
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

    /** @var array|string[]  */
    public static array $body = [
        'class' => 'd-flex flex-column h-100'
    ];

    /** @var array|string[]  */
    public static array $main = [
        'class' => 'flex-shrink-0'
    ];

    public static array $footer = [
        'class' => 'footer mt-auto py-3 text-muted'
    ];

    /**
     * @param $name
     *
     * @return string
     */
    public static function meta($name): string
    {
        return Html::tag('meta', null, self::$meta[$name]);
    }
}