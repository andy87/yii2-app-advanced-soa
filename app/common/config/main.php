<?php

$dirApp = dirname(__DIR__, 2);
$root = dirname(__DIR__, 3);

return [
    'vendorPath' => "$root/vendor",

    'aliases' => [
        '@bower'    => '@vendor/bower-asset',
        '@npm'      => '@vendor/npm-asset',
        '@uploads'  => "$root/uploads",
        '@common'   => "$dirApp/common",
        '@frontend' => "$dirApp/frontend",
        '@backend'  => "$dirApp/backend",
        '@console'  => "$dirApp/console",
    ],

    'components' => [
        'cache' => require __DIR__ . '/components/cache.php',
    ],

    'container' => [
        'definitions' => require __DIR__ . '/container/definitions.php',
    ],
];
