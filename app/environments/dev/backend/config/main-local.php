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

return $config;
