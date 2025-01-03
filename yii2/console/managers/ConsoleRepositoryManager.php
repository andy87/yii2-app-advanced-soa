<?php

namespace console\managers;

use common\managers\CommonRepositoryManager;
use console\repository\items\{UserRepository};
use console\repository\items\PascalCaseRepository;

/**
 * < Common > Менеджер сервисов
 *
 * @property-read \console\repository\items\UserRepository $user
 * @property-read \console\repository\items\PascalCaseRepository $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class ConsoleRepositoryManager extends CommonRepositoryManager
{
    public const string USER = 'userService';
    public const string PASCALE_CASE = 'PascalCase';



    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        ...CommonRepositoryManager::CONFIG,
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