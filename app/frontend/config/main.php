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

        'errorHandler' => require __DIR__ . '/components/errorHandler.php',

        'log' => require __DIR__ . '/components/log.php',

        'request' => require __DIR__ . '/components/request.php',

        'session' => require __DIR__ . '/components/session.php',

        'urlManager' => require __DIR__ . '/components/urlManager.php',

        'user' => require __DIR__ . '/components/user.php',
    ],

    'params' => $params,
];
