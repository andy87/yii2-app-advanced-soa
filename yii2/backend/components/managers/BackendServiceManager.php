<?php

namespace yii2\backend\components\managers;

use yii2\common\components\managers\CommonServiceManager;
use yii2\backend\components\services\controllers\AuthService;
use yii2\backend\components\services\items\{ UserService, PascalCaseService };

/**
 * < Common > Менеджер сервисов
 *
 * @property-read UserService $user
 * @property-read AuthService $auth
 * @property-read PascalCaseService $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class BackendServiceManager extends CommonServiceManager
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
        ...CommonServiceManager::CONFIG,
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