<?php declare(strict_types=1);

/**
 * < Console > Singleton для контейнера зависимостей
 *
 * @package yii2\console\config\container
 */

use console\services\AuthService;
use console\services\items\UserService;
use console\repository\items\UserRepository;
use console\services\items\PascalCaseService;
use console\handlers\items\PascalCaseHandler;
use console\producers\items\PascalCaseProducer;
use console\repository\items\PascalCaseRepository;
use console\managers\ConsoleHandlerManager;
use console\managers\ConsoleServiceManager;
use console\managers\ConsoleRepositoryManager;

return [

    // Managers
    ConsoleHandlerManager::class => [ 'class' => ConsoleHandlerManager::class ],
    ConsoleServiceManager::class => [ 'class' => ConsoleServiceManager::class ],
    ConsoleRepositoryManager::class => [ 'class' => ConsoleRepositoryManager::class ],


    // Handlers --> Items
    PascalCaseHandler::class => [ 'class' => PascalCaseHandler::class ],

    // Services
    AuthService::class => [ 'class' => AuthService::class ],

    // Services --> Items
    UserService::class => [ 'class' => UserService::class ],
    PascalCaseService::class => [ 'class' => PascalCaseService::class ],


    // Repositories

    // Repositories --> Items
    UserRepository::class => [ 'class' => UserRepository::class ],
    PascalCaseRepository::class => [ 'class' => PascalCaseRepository::class ],


    // Producers --> Items
    PascalCaseProducer::class => [ 'class' => PascalCaseProducer::class ],

];