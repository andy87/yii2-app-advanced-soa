<?php

use yii\db\Connection;
use yii\symfonymailer\Mailer;

return [
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => $_ENV['DB_DSN_LOCAL'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => $_ENV['DB_CHARSET'],
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@common/mail',
            // send all mails to a file by default.
            'useFileTransport' => $_ENV['MAILER_USE_FILE_TRANSPORT'],
            // You have to set
            //
            // 'useFileTransport' => false,
            //
            // and configure a transport for the mailer to send real emails.
            //
            // SMTP server example:
            //    'transport' => [
            //        'scheme' => $_ENV['MAILER_SCHEME'],
            //        'host' => $_ENV['MAILER_HOST'],
            //        'username' => $_ENV['MAILER_USERNAME'],
            //        'password' => $_ENV['MAILER_PASSWORD'],
            //        'port' => $_ENV['MAILER_PORT'],
            //        'dsn' => $_ENV['MAILER_DSN'],
            //    ],
            //
            // DSN example:
            //    'transport' => [
            //        'dsn' => 'smtp://user:pass@smtp.example.com:25',
            //    ],
            //
            // See: https://symfony.com/doc/current/mailer.html#using-built-in-transports
            // Or if you use a 3rd party service, see:
            // https://symfony.com/doc/current/mailer.html#using-a-3rd-party-transport
        ],
    ],
];
