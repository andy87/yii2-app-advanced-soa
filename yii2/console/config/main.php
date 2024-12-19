<?php

use andy87\yii2\architect\components\controllers\ArchitectController;
use yii2\console\components\managers\{ ConsoleHandlerManager, ConsoleRepositoryManager, ConsoleServiceManager };

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [

    'id' => $_ENV['APP_CONSOLE_ID'],

    'basePath' => dirname(__DIR__),

    'controllerNamespace' => 'yii2\console\controllers',

    'components' => [
        'log' => require __DIR__ . '/components/log.php',

        'serviceManager' => [
            'class' => ConsoleServiceManager::class,
            'config' => ConsoleServiceManager::CONFIG,
        ],

        'handlerManager' => [
            'class' => ConsoleHandlerManager::class,
            'config' => ConsoleHandlerManager::CONFIG,
        ],

        'repositoryManager' => [
            'class' => ConsoleRepositoryManager::class,
            'config' => ConsoleRepositoryManager::CONFIG,
        ]
    ],

    'bootstrap' => ['log'],

    'params' => $params,

    'controllerMap' => [

        'fixture' => [
            'class' => yii\console\controllers\FixtureController::class,
            'namespace' => 'common\fixtures',
        ],

        'migration' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => ['@console/migrations'],
        ],

        'architect' => [
            'class' => ArchitectController::class,
            'migrationPath' => ['@console/migrations'],
        ],
    ],
];