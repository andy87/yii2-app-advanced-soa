<?php

namespace common\managers;

use common\services\AuthService;
use common\services\EmailService;
use common\services\FormService;
use common\services\IdentityService;
use common\services\items\PascalCaseService;
use common\services\items\UserService;
use common\services\ModelService;
use common\components\base\managers\ServiceManager;


/**
 * < Common > Менеджер сервисов
 *
 * @property-read \common\services\items\UserService $user
 * @property-read \common\services\AuthService $auth
 * @property-read EmailService $email
 * @property-read FormService $form
 * @property-read IdentityService $identity
 * @property-read \common\services\ModelService $model
 * @property-read \common\services\items\PascalCaseService $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class CommonServiceManager extends ServiceManager
{
    public const string AUTH = 'authService';
    public const string EMAIL = 'emailService';

    public const string FORM = 'formService';
    public const string IDENTITY = 'identityService';
    public const string MODEL = 'modelService';
    public const string USER = 'userService';
    public const string PASCALE_CASE = 'PascalCaseService';


    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        self::USER => ['class' => UserService::class ],
        self::AUTH => ['class' => AuthService::class ],
        self::EMAIL => ['class' => EmailService::class ],
        self::FORM => ['class' => FormService::class ],
        self::IDENTITY => ['class' => IdentityService::class ],
        self::MODEL => ['class' => ModelService::class ],
        self::PASCALE_CASE => ['class' => PascalCaseService::class ],
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}