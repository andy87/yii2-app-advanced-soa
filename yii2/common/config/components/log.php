<?php

return [
    'traceLevel' => YII_DEBUG ? 3 : 0,
    'targets' => [
        [
            'class' => yii\log\FileTarget::class,
            'levels' => ['error', 'warning'],
        ],
    ],
];