<?php

namespace yii2\common\components\managers;

use yii2\common\components\base\managers\ServiceManager;
use yii2\common\components\services\AuthService;
use yii2\common\components\services\EmailService;
use yii2\common\components\services\FormService;
use yii2\common\components\services\IdentityService;
use yii2\common\components\services\ModelService;
use yii2\common\components\services\items\UserService;
use yii2\common\components\services\items\PascalCaseService;


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