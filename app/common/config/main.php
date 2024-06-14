<?php

use Dotenv\Dotenv;
use yii\caching\FileCache;

$dirApp = dirname(__DIR__, 2);

$root = dirname(__DIR__, 3);

Dotenv::createImmutable($root,'.env')->load();

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
