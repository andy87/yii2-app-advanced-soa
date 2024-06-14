<?php

use yii\caching\FileCache;

$dirApp = dirname(__DIR__, 2);

$root = dirname(__DIR__, 3);

return [
    'vendorPath' => $dirApp . '/vendor',

    'aliases' => [
        '@bower'    => '@vendor/bower-asset',
        '@npm'      => '@vendor/npm-asset',
        '@uploads'  => $root . '/uploads',
    ],

    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
    ],
];
