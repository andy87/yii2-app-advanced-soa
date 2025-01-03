<?php

namespace backend\managers;

use common\managers\CommonServiceManager;
use backend\repository\items\UserRepository;
use backend\repository\items\PascalCaseRepository;

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
class BackendRepositoryManager extends CommonServiceManager
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
        self::USER => ['class' => UserRepository::class ],
        self::PASCALE_CASE => ['class' => PascalCaseRepository::class ],
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}