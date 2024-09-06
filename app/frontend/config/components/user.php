<?php

return [
    'identityClass' => app\common\models\Identity::class,
    'enableAutoLogin' => true,
    'identityCookie' => [
        'name' => $_ENV['APP_FRONTEND_IDENTITY_COOKIE'],
        'httpOnly' => true
    ],
    'loginUrl' => ['auth/login']
];