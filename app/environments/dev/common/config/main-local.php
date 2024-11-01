<?php

$config = [];

if (YII_ENV_DEV)
{
    $moduleList = [
        'debug' => yii\debug\Module::class,
        'gii' => yii\gii\Module::class,
    ];

    foreach ($moduleList as $module => $class)
    {
        $config['bootstrap'][] = $module;
        $config['modules'][$module] = ['class' => $class];
    }

    $moduleList = [
        'debug' => yii\debug\Module::class,
        'gii' => yii\gii\Module::class,
    ];

    foreach ($moduleList as $module => $class)
    {
        $config['bootstrap'][] = $module;
        $config['modules'][$module] = ['class' => $class];
    }

    $config['bootstrap'][] = function ()
    {
        Yii::$app->setBasePath('@app');
    };
}

return $config;