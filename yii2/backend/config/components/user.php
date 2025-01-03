<?php

use backend\controllers\AuthController;
use common\components\enums\Endpoints;

return [
    'identityClass' => common\models\Identity::class,
    'enableAutoLogin' => true,
    'identityCookie' => [
        'name' => $_ENV['APP_BACKEND_IDENTITY_COOKIE'],
        'httpOnly' => true
    ],
    'loginUrl' => [AuthController::ENDPOINT . '/' . Endpoints::LOGIN],
];