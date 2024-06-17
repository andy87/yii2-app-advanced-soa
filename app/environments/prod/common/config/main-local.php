<?php

return [
    'components' => [
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => $_ENV['DB_DSN_LOCAL'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => $_ENV['DB_CHARSET'],
        ],
        'mailer' => [
            'class' => yii\symfonymailer\Mailer::class,
            'transport' => [
                'scheme' => $_ENV['MAILER_SCHEME'],
                'host' => $_ENV['MAILER_HOST'],
                'username' => $_ENV['MAILER_USERNAME'],
                'password' => $_ENV['MAILER_PASSWORD'],
                'port' => $_ENV['MAILER_PORT'],
                'dsn' => $_ENV['MAILER_DSN'],
            ],
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
    ],
];
