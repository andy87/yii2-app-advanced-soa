<?php

$dirApp = dirname(__DIR__, 2);
$root = dirname(__DIR__, 3);

$config = [
    'vendorPath' => "$root/vendor",

    'aliases' => [
        '@bower'    => '@vendor/bower-asset',
        '@npm'      => '@vendor/npm-asset',
        '@root'     => $root,
        '@yii2'     => "$root/yii2",
        '@uploads'  => "$root/uploads",
        '@mode'     => $dirApp,
        '@common'   => "$dirApp/common",
        '@frontend' => "$dirApp/frontend",
        '@backend'  => "$dirApp/backend",
        '@console'  => "$dirApp/console",
    ],

    'components' => [

        'db' => require __DIR__ . '/components/db.php',

        'cache' => require __DIR__ . '/components/cache.php',

        'mailer' => require __DIR__ . '/components/mailer.php',

        //'redis' => require __DIR__ . '/components/redis.php',

        //'rabbitMq' => require __DIR__ . '/components/rabbitMq.php',

        //'elasticsearch' => require __DIR__ . '/components/elasticsearch.php',
    ],
];

$config['container'] = [
    'definitions' => require __DIR__ . '/container/definitions.php',
];

return $config;
