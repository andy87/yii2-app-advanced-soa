<?php

use yii2\backend\components\managers\BackendServiceManager;
use yii2\common\components\managers\CommonServiceManager;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$basePath = dirname(__DIR__);

return [
    'id' => $_ENV['APP_BACKEND_ID'],

    'basePath' => $basePath,

    'controllerNamespace' => 'yii2\backend\controllers',

    'aliases' => [
        '@app'      => $basePath,
    ],

    'components' => [

        'request' => require __DIR__ . '/components/request.php',

        'user' => require __DIR__ . '/components/user.php',

        'session' => require __DIR__ . '/components/session.php',

        'urlManager' => require __DIR__ . '/components/urlManager.php',

        'log' => require __DIR__ . '/../../common/config/components/log.php',

        'errorHandler' => require __DIR__ . '/../../common/config/components/errorHandler.php',

        'serviceManager' => [
            'class' => BackendServiceManager::class,
            'config' => BackendServiceManager::CONFIG,
        ]
    ],

    'bootstrap' => ['log'],

    'modules' => [],

    'params' => $params,
];