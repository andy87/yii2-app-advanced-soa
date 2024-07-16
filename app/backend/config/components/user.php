<?php

return [
    'identityClass' => app\common\models\Identity::class,
    'enableAutoLogin' => true,
    'identityCookie' => [
        'name' => $_ENV['APP_BACKEND_IDENTITY_COOKIE'],
        'httpOnly' => true
    ],
];