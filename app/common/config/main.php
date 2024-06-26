<?php

use yii\caching\FileCache;

$dirApp = dirname(__DIR__, 2);
$root = dirname(__DIR__, 3);

return [
    'vendorPath' => "$root/vendor",

    'aliases' => [
        '@bower'    => '@vendor/bower-asset',
        '@npm'      => '@vendor/npm-asset',
        '@uploads'  => "$root/uploads",
        '@common'   => "$dirApp/common",
        '@frontend' => "$dirApp/frontend",
        '@backend'  => "$dirApp/backend",
        '@console'  => "$dirApp/console",
    ],

    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
    ],

    'container' => [
        'definitions' => [
            \yii\web\View::class => \app\common\components\View::class,
            \yii\widgets\LinkPager::class => \yii\bootstrap5\LinkPager::class,
        ],
    ],
];
