<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    require __DIR__ . '/test-local.php',
    [
        'components' => [
            'request' => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                'cookieValidationKey' => '',
            ],

            'user' => [
                'identityClass' => yii2\common\models\Identity::class,
                'identityCookie' => [
                    'name' => 'codecept_test',
                    'httpOnly' => true
                ],
                'enableSession' => false,
            ],
        ],
    ]
);
