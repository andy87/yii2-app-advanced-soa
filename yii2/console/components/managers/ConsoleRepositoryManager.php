<?php

namespace yii2\console\components\managers;

use yii2\common\components\managers\CommonRepositoryManager;
use yii2\console\components\repository\items\{ UserRepository, PascalCaseRepository };

/**
 * < Common > Менеджер сервисов
 *
 * @property-read UserRepository $user
 * @property-read PascalCaseRepository $pascalCase
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