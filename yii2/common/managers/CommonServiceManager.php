<?php

namespace common\managers;

use common\services\AuthService;
use common\services\FormService;
use common\services\ModelService;
use common\services\EmailService;
use common\services\IdentityService;
use common\services\items\UserService;
use common\services\items\PascalCaseService;
use common\components\base\managers\ServiceManager;

/**
 * < Common > Менеджер сервисов
 *
 * @property-read UserService $user
 * @property-read AuthService $auth
 * @property-read EmailService $email
 * @property-read FormService $form
 * @property-read IdentityService $identity
 * @property-read ModelService $model
 * @property-read PascalCaseService $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class CommonServiceManager extends ServiceManager
{
    public const string AUTH = 'auth';
    public const string EMAIL = 'email';

    public const string FORM = 'form';
    public const string IDENTITY = 'identity';
    public const string MODEL = 'model';
    public const string USER = 'user';
    public const string PASCALE_CASE = 'PascalCase';


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