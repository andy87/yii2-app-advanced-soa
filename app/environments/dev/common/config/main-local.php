<?php

use yii\base\Event;

require_once "__snippets.php";

$config = [];

if (YII_ENV_DEV)
{
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = yii\debug\Module::class;

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = yii\gii\Module::class;

    $config['bootstrap'][] = function ()
    {
        Event::on(yii\gii\Module::class, yii\base\Module::EVENT_BEFORE_ACTION, function ()
        {
            Yii::$app->setBasePath('@root/app');
        });
    };
}

return $config;