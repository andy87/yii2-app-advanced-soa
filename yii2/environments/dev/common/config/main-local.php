<?php

$config = [];

if (YII_ENV_DEV)
{
    $allowedIps = ['127.0.0.1', '::1', '172.*.*.*'];

    $moduleList = [
        'debug' => [
            'class' => yii\debug\Module::class,
            'allowedIPs' => $allowedIps,
        ],
        'gii' => [
            'class' => yii\gii\Module::class,
            'allowedIPs' => $allowedIps,
        ],
    ];

    foreach ($moduleList as $module => $definition)
    {
        $config['bootstrap'][] = $module;
        $config['modules'][$module] = $definition;
    }
}

return $config;
