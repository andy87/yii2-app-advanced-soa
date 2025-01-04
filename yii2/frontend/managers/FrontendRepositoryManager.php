<?php

namespace frontend\managers;

use common\managers\CommonServiceManager;
use frontend\repository\items\PascalCaseRepository;
use frontend\repository\items\UserRepository;

/**
 * < Common > Менеджер репозиториев
 *
 * @property-read UserRepository $user
 * @property-read PascalCaseRepository $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #repository
 */
class FrontendRepositoryManager extends CommonServiceManager
{
    public const string USER = 'userRepository';
    public const string PASCALE_CASE = 'PascalCaseRepository';


    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        ...CommonServiceManager::CONFIG,
        self::USER => UserRepository::class,
        self::PASCALE_CASE => PascalCaseRepository::class,
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}