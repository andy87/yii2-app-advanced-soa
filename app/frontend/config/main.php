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

    'controllerNamespace' => 'app\frontend\controllers',

    'components' => [

        'request' => require __DIR__ . '/components/request.php',

        'user' => require __DIR__ . '/components/user.php',

        'session' => require __DIR__ . '/components/session.php',

        'log' => require __DIR__ . '/components/log.php',

        'urlManager' => require __DIR__ . '/components/urlManager.php',

        'errorHandler' => require __DIR__ . '/components/errorHandler.php',
    ],

    'bootstrap' => ['log'],

    'modules' => [],

    'params' => $params,
];