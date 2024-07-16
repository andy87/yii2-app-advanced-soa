<?php

use app\common\models\Identity;

return [
    'identityClass' => Identity::class,
    'enableAutoLogin' => true,
    'identityCookie' => [
        'name' => $_ENV['APP_BACKEND_IDENTITY_COOKIE'],
        'httpOnly' => true
    ],
];