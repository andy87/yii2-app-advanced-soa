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
    'id' => $_ENV['APP_FRONTEND_ID'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\frontend\controllers',
    'components' => [

        'request' => __DIR__ . '/components/request.php',

        'user' => __DIR__ . '/components/user.php',

        'session' => __DIR__ . '/components/session.php',

        'log' => __DIR__ . '/components/log.php',

        'urlManager' => __DIR__ . '/components/urlManager.php',

        'errorHandler' => [
            'errorAction' => 'system/error',
        ],
    ],

    'params' => $params,
];
