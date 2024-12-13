<?php

return [
    'class' => yii\symfonymailer\Mailer::class,
    'transport' => [
        'scheme' => $_ENV['MAILER_SCHEME'],
        'host' => $_ENV['MAILER_HOST'],
        'username' => $_ENV['MAILER_USERNAME'],
        'password' => $_ENV['MAILER_PASSWORD'],
        'port' => $_ENV['MAILER_PORT'],
        'dsn' => $_ENV['MAILER_DSN'],
    ],
    'viewPath' => $_ENV['MAILER_VIEW_PATH'],
    'useFileTransport' => $_ENV['MAILER_USE_FILE_TRANSPORT']
];