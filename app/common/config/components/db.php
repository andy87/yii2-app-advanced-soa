
<?php

return [
    'class' => yii\db\Connection::class,
    'dsn' => $_ENV['DB_DSN_LOCAL'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => $_ENV['DB_CHARSET'],
];