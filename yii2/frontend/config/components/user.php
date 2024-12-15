<?php

return [
    'identityClass' => yii2\common\models\Identity::class,
    'enableAutoLogin' => true,
    'identityCookie' => [
        'name' => $_ENV['APP_FRONTEND_IDENTITY_COOKIE'],
        'httpOnly' => true
    ],
    'loginUrl' => ['auth/login']
];