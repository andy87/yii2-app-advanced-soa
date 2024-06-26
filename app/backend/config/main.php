<?php

use yii\log\FileTarget;
use app\common\models\Identity;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => $_ENV['APP_BACKEND_ID'],
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [

        'request' => [
            'csrfParam' => $_ENV['APP_BACKEND_CSRF_PARAM'],
            'baseUrl' => $_ENV['APP_BACKEND_BASE_URL'],
        ],

        'user' => [
            'identityClass' => Identity::class,
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => $_ENV['APP_BACKEND_IDENTITY_COOKIE'],
                'httpOnly' => true
            ],
        ],

        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => $_ENV['APP_BACKEND_SESSION_NAME'],
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'errorHandler' => [
            'errorAction' => 'system/error',
        ],

        'urlManager' => [
            'hostInfo' => $_ENV['APP_BACKEND_HOST'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/' => '<controller>/index',
            ],
        ],

    ],
    'params' => $params,
];
