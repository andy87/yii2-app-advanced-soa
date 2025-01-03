<?php

return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\Identity::class,
        ],
    ],
    'params' => require __DIR__ . '/params.php',
];
