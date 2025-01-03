<?php

namespace frontend\managers;

use frontend\services\{items\PascalCaseService};
use frontend\services\AuthService;
use frontend\services\items\UserService;

/**
 * < Common > Менеджер сервисов
 *
 * @property-read \frontend\services\items\UserService $user
 * @property-read AuthService $auth
 * @property-read PascalCaseService $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class FrontendServiceManager extends \common\managers\CommonServiceManager
{
    public const string AUTH = 'authService';
    public const string USER = 'userService';
    public const string PASCALE_CASE = 'PascalCase';


    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        ...\common\managers\CommonServiceManager::CONFIG,
        self::USER => ['class' => UserService::class ],
        self::AUTH => ['class' => AuthService::class ],
        self::PASCALE_CASE => ['class' => PascalCaseService::class ],
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}