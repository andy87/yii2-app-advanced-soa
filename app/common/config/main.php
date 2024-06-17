<?php

use yii\caching\FileCache;

$root = dirname(__DIR__, 3);

return [
    'vendorPath' => $root . '/vendor',

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
