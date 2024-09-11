<?php

use yii\base\Event;

$config = [];

if (YII_ENV_DEV) {
    $config = [
        'bootstrap' => ['gii'],
        'modules' => [
            'gii' => yii\gii\Module::class,
            'aliases' => ['@app' => dirname(__DIR__, 2) ]
        ],
    ];
    $config['bootstrap'][] = function () {
        Event::on(yii\gii\Module::class, yii\base\Module::EVENT_BEFORE_ACTION, function ($event)
        {
            $module = $event->sender;

            if ($module->id === 'gii') {
                Yii::setAlias('@app', dirname(__DIR__, 2));
            }
        });
    };
}

return $config;