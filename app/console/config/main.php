<?php


use andy87\yii2\architect\components\controllers\ArchitectController;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => $_ENV['APP_CONSOLE_ID'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\console\controllers',

    'controllerMap' => [

        'fixture' => [
            'class' => yii\console\controllers\FixtureController::class,
            'namespace' => 'common\fixtures',
          ],

        'migration' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => ['@console/migrations'],
        ],

        'architect' => ArchitectController::class,
    ],

    'components' => [
        'log' => require __DIR__ . '/components/log.php',
    ],

    'params' => $params,
];