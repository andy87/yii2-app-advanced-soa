<?php

namespace backend\managers;

use backend\services\items\UserService;
use common\managers\CommonServiceManager;
use backend\services\controllers\AuthService;
use backend\services\items\PascalCaseService;

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
    public const string AUTH = 'auth';
    public const string USER = 'user';
    public const string PASCALE_CASE = 'PascalCase';



    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        ...CommonServiceManager::CONFIG,
        self::USER => UserService::class,
        self::AUTH => AuthService::class,
        self::PASCALE_CASE => PascalCaseService::class,
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}