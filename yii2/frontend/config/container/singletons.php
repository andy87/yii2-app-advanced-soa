<?php declare(strict_types=1);

/**
 * < Frontend > Singletons для контейнера зависимостей
 *
 * @package yii2\backend\config\container
 */

use frontend\services\AuthService;
use frontend\services\SiteService;
use frontend\services\items\UserService;
use frontend\managers\FrontendServiceManager;
use frontend\managers\FrontendHandlerManager;
use frontend\repository\items\UserRepository;
use frontend\services\items\PascalCaseService;
use frontend\managers\FrontendRepositoryManager;
use frontend\producers\items\PascalCaseProducer;
use frontend\repository\items\PascalCaseRepository;

return [

    // Managers
    FrontendHandlerManager::class => [ 'class' => FrontendHandlerManager::class ],
    FrontendServiceManager::class => [ 'class' => FrontendServiceManager::class ],
    FrontendRepositoryManager::class => [ 'class' => FrontendRepositoryManager::class ],


    // Services
    AuthService::class => [ 'class' => AuthService::class ],
    SiteService::class => [ 'class' => SiteService::class ],

    // Services --> Items
    UserService::class => [ 'class' => UserService::class ],
    PascalCaseService::class => [ 'class' => PascalCaseService::class ],


    // Repositories --> Items
    PascalCaseRepository::class => [ 'class' => PascalCaseRepository::class ],
    UserRepository::class => [ 'class' => UserRepository::class ],


    // Producers --> Items
    PascalCaseProducer::class => [ 'class' => PascalCaseProducer::class ],
];