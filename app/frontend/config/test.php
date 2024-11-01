<?php

use yii\symfonymailer\Message;

return [
    'id' => $_ENV['APP_FRONTEND_ID_TEST'],
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
        ],
        'mailer' => [
            'messageClass' => Message::class
        ]
    ],
];
