<?php

/**
 * Elasticsearch configuration
 *
 *"yiisoft/yii2-elasticsearch" : "~2.1.0"
 */

return [
    'class' => yii\elasticsearch\Connection::class,
    'nodes' => [
        ['http_address' => $_ENV['ELK_ADDRESS']],
    ],
    'autodetectCluster' => false,
    'connectionTimeout' => 1,
    'dslVersion' => 7, // default is 5
];