<?php

return [
    'hostInfo' => $_ENV['APP_BACKEND_HOST'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '<controller:\w+>/<id:\d+>' => '<controller>/view',
        '<controller:\w+>/' => '<controller>/index',
    ],
];