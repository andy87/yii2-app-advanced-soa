<?php

$config = [];

if (YII_ENV_DEV) {
    $config = [
        'bootstrap' => ['gii'],
        'modules' => [
            'gii' => yii\gii\Module::class
        ],
    ];
}

return $config;