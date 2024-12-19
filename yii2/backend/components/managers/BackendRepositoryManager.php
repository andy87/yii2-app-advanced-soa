<?php

namespace yii2\backend\components\managers;

use yii2\common\components\managers\CommonServiceManager;
use yii2\backend\components\repository\items\PascalCaseRepository;
use yii2\backend\components\repository\items\UserRepository;

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