<?php

use frontend\managers\FrontendHandlerManager;
use frontend\managers\FrontendRepositoryManager;
use frontend\managers\FrontendServiceManager;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$basePath = dirname(__DIR__);

return [
    'id' => $_ENV['APP_FRONTEND_ID'],

    'basePath' => $basePath,

    'controllerNamespace' => 'frontend\controllers',

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
            'class' => FrontendServiceManager::class,
            'config' => FrontendServiceManager::CONFIG,
        ],

        'handlerManager' => [
            'class' => FrontendHandlerManager::class,
            'config' => FrontendHandlerManager::CONFIG,
        ],

        'repositoryManager' => [
            'class' => FrontendRepositoryManager::class,
            'config' => FrontendRepositoryManager::CONFIG,
        ]
    ],

    'container' => [
        'definitions' => require __DIR__ . '/container/definitions.php',
        'singletons' => require __DIR__ . '/container/singletons.php',
    ],

    'bootstrap' => ['log'],

    'modules' => [],

    'params' => $params
];