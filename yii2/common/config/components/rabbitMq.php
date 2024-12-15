<?php

/**
 * Конфигурация для RabbitMQ
 *
 * "php-mqtt/client" : "dev-master"
 */

$config = [
    'class' => mikemadisonweb\rabbitmq\Configuration::class,
    'logger' => [
        'log' => true,
        'category' => 'application',
        'print_console' => false,
        'system_memory' => false,
    ],

    'connections' => [
        [
            'host' => $_ENV['RABBITMQ_HOST'],
            'port' => $_ENV['RABBITMQ_PORT'],
            'user' => $_ENV['RABBITMQ_USER'],
            'password' => $_ENV['RABBITMQ_PASSWORD'],
            'vhost' => $_ENV['RABBITMQ_VHOST'],
            'heartbeat' => $_ENV['RABBITMQ_HEARTBEAT'],
        ],
    ],
    'exchanges' => [],
    'queues' => [],
    'bindings' => [],
    'producers' => [],
    'consumers' => [],
];

//Список настроек консамеров.

$consumerList = [

    //  Конфигурация для быстрых настроек консамеров:
    //      * class - класс консамера
    //      * exchangeName - значение для [exchanges][name] ( по умолчанию "exchange-{$consumerKey}" )
    //      * exchangesType - значение для [exchanges][type] ( по умолчанию 'direct' )
    //      * queueName - значение для [queues][name] ( по умолчанию "queue-{$consumerKey}" )
    //      * queuesDurable - значение для [queues][durable] ( по умолчанию true )
    //      * exchangeName - значение для [exchanges][name] ( по умолчанию "exchange-{$consumerKey}" )
    //      * bindingsRoutingKeys - значение для [bindings][routing_keys] ( по умолчанию [ '12344321' ] )
    //      * producerName - значение для [producers][name] ( по умолчанию "producer-{$consumerKey}" )
    //      * consumerName - значение для [consumers][name] ( по умолчанию "consumer-{$consumerKey}" )
    //
    // Конфигурация для полных настроек консамеров:
    //      * exchange - массив с настройками для exchange
    //      * queue     - массив с настройками для queue
    //      * bindings  - массив с настройками для bindings
    //      * producer  - массив с настройками для producer
    //      * consumer  - массив с настройками для consumer
    //
    //  Простейшая настройка консамера - добавление в массив $consumerList записи вида:
    //     [ 'consumer-unique-name' => yii2\components\rabbitmq\UniqueNameConsumer::class]

    ['notify' => [
        'class' => \yii2\components\rabbitmq\consumers\NameConsumer::class,
        'bindingsRoutingKeys' => ['12345678'],
    ]],
];

// Динамическая генерация конфигурации для консамеров
// После генерации, настройки идентичны настройкам из оригинального файла.
foreach ($consumerList as $consumerData) {

    $consumerKey = key($consumerData);
    $consumerData = $consumerData[$consumerKey];
    $consumerClass = (is_array($consumerData)) ? $consumerData['class'] : $consumerData;

    $exchange = $consumerData['exchange'] ?? [
        'name' => $consumerData['exchangeName'] ?? ('exchange-' . $consumerKey),
        'type' => $consumerData['exchangesType'] ?? 'direct',
    ];

    $queueName = $consumerData['queueName'] ?? ('queue-' . $consumerKey);

    $queue = $consumerData['queue'] ?? [
        'name' => $queueName,
        'durable' => $consumerData['queuesDurable'] ?? true,
    ];

    $binding = $consumerData['bindings'] ?? [
        'queue' => $consumerData['queueName'] ?? ('queue-' . $consumerKey),
        'exchange' => $consumerData['exchangeName'] ?? ('exchange-' . $consumerKey),
        'routing_keys' => $consumerData['bindingsRoutingKeys'] ?? ['qwerty'],
    ];

    $producer = $consumerData['producer'] ?? [
        'name' => $consumerData['producerName'] ?? ('producer-' . $consumerKey),
    ];

    $consumer = $consumerData['consumer'] ?? [
        'name' => $consumerData['consumerName'] ?? ('consumer-' . $consumerKey),
        'callbacks' => [
            $queueName => $consumerClass,
        ],
    ];

    $config['exchanges'][] = $exchange;
    $config['queues'][] = $queue;
    $config['bindings'][] = $binding;
    $config['producers'][] = $producer;
    $config['consumers'][] = $consumer;
}

return $config;

/* Старый массив
return= [
    'class' => Configuration::class,
    //'auto_declare'      => false,
    'logger' => [
        'log' => true,
        'category' => 'application',
        'print_console' => false,
        'system_memory' => false,
    ],

    'connections' => [
        [
            'host' => $_ENV['RABBITMQ_HOST'],
            'port' => $_ENV['RABBITMQ_PORT'],
            'user' => $_ENV['RABBITMQ_USER'],
            'password' => $_ENV['RABBITMQ_PASSWORD'],
            'vhost' => $_ENV['RABBITMQ_VHOST'],
            'heartbeat' => $_ENV['RABBITMQ_HEARTBEAT'],
        ],
    ],

    'exchanges' => [
        [
            'name' => 'exchange-name',
            'type' => 'direct',
        ],
    ],
    'queues' => [
        [
            'name' => 'queue-name',
            'durable' => true,
        ],
    ],
    'bindings' => [
        [
            'queue' => 'queue-name',
            'exchange' => 'exchange-name',
            'routing_keys' => [
                'random-string',
            ],
        ]
    ],
    'producers' => [
        ['name' => 'producer-name',],
    ],
    'consumers' => [
        [
            'name' => 'consumer-name',
            'callbacks' => [
                'queue-name' => yii2\components\rabbitmq\NameConsumer::class,
            ],
        ],
    ]
];*/

