<?php

/**
 * Redis configuration
 *
 * "yiisoft/yii2-redis"
 */

return [
    'class' => yii\redis\Connection::class,
    'hostname' => $_ENV['REDIS_CONTAINER_NAME'],
    'port' => (int)$_ENV['REDIS_CONTAINER_PORT'],
    'database' => (int)$_ENV['REDIS_CONTAINER_DATABASE'],
    'password' => $_ENV['REDIS_CONTAINER_PASSWORD'] ?: null,
];
