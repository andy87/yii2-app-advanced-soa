<?php declare(strict_types=1);

/**
 * < Common > Singleton для контейнера зависимостей
 *
 * @package yii2\backend\config\container
 */

use common\services\AuthService;
use common\services\FormService;
use common\services\EmailService;
use common\services\ModelService;
use common\services\IdentityService;
use common\services\items\UserService;
use common\repository\IdentityRepository;
use common\repository\items\UserRepository;
use common\services\items\PascalCaseService;
use common\handlers\items\PascalCaseHandler;
use common\producers\items\PascalCaseProducer;
use common\repository\items\PascalCaseRepository;

return [

    // Handlers --> Items
    PascalCaseHandler::class => [ 'class' => PascalCaseHandler::class ],

    // Services
    AuthService::class => [ 'class' => AuthService::class ],
    EmailService::class => [ 'class' => EmailService::class ],
    FormService::class => [ 'class' => FormService::class ],
    IdentityService::class => [ 'class' => IdentityService::class ],
    ModelService::class => [ 'class' => ModelService::class ],

    // Services --> Items
    UserService::class => [ 'class' => UserService::class ],
    PascalCaseService::class => [ 'class' => PascalCaseService::class ],


    // Repositories
    IdentityRepository::class => [ 'class' => IdentityRepository::class ],

    // Repositories --> Items
    UserRepository::class => [ 'class' => UserRepository::class ],
    PascalCaseRepository::class => [ 'class' => PascalCaseRepository::class ],


    // Producers --> Items
    PascalCaseProducer::class => [ 'class' => PascalCaseProducer::class ],

];