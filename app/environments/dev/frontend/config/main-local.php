<?php

use yii\base\Event;
use andy87\yii2\builder\components\Builder;

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            Builder::ID => [
                'class' => Builder::class,
                'templates' => [
                    'default' => Builder::TEMPLATE,
                ]
            ]
        ]
    ];


    $config['bootstrap'][] = function () {
        Event::on(yii\gii\Module::class, yii\gii\Module::EVENT_BEFORE_ACTION, function ($event)
        {
            $module = $event->sender;

            if ($module->id === 'gii') {
                Yii::setAlias('@app', dirname(__DIR__, 2));
            }
        });
    };
}

return $config;
