<?php declare(strict_types=1);

/**
 * < Backend > Singleton для контейнера зависимостей
 *
 * @package yii2\backend\config\container
 */

use backend\services\items\UserService;
use backend\managers\BackendHandlerManager;
use backend\managers\BackendServiceManager;
use backend\repository\items\UserRepository;
use backend\services\items\PascalCaseService;
use backend\handlers\items\PascalCaseHandler;
use backend\services\controllers\AuthService;
use backend\managers\BackendRepositoryManager;
use backend\producers\items\PascalCaseProducer;
use backend\repository\items\PascalCaseRepository;

return [

    // Managers
    BackendHandlerManager::class => [ 'class' => BackendHandlerManager::class ],
    BackendServiceManager::class => [ 'class' => BackendServiceManager::class ],
    BackendRepositoryManager::class => [ 'class' => BackendRepositoryManager::class ],

    // Handlers --> Items
    PascalCaseHandler::class => [ 'class' => PascalCaseHandler::class ],

    // Services --> Items
    UserService::class => [ 'class' => UserService::class ],
    PascalCaseService::class => [ 'class' => PascalCaseService::class ],

    // Services --> Controller
    AuthService::class => [ 'class' => AuthService::class ],


    // Repositories --> Items
    UserRepository::class => [ 'class' => UserRepository::class ],
    PascalCaseRepository::class => [ 'class' => PascalCaseRepository::class ],


    // Producers --> Items
    PascalCaseProducer::class => [ 'class' => PascalCaseProducer::class ],
];