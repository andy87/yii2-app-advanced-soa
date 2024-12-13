<?php

use yii\log\FileTarget;
use yii2\common\models\Identity;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => $_ENV['APP_FRONTEND_ID'],

    'basePath' => dirname(__DIR__),

    'controllerNamespace' => 'yii2\frontend\controllers',

    'components' => [

        'request' => require __DIR__ . '/components/request.php',

        'user' => require __DIR__ . '/components/user.php',

        'session' => require __DIR__ . '/components/session.php',

        'urlManager' => require __DIR__ . '/components/urlManager.php',

        'log' => require __DIR__ . '/../../common/config/components/log.php',

        'errorHandler' => require __DIR__ . '/../../common/config/components/errorHandler.php',
    ],

    'bootstrap' => ['log'],

    'modules' => [],

    'params' => $params,
];