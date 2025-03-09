<?php

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
            'fileCrafter' => [
                'class' => andy87\yii2\file_crafter\Crafter::class,
                'options' => [
                    'templates' => [
                        'group_name' => [
                            // 'template' => 'path/to/file.php',
                            // ...
                        ]
                    ]
                ]
            ]
        ],
    ];
}

return $config;