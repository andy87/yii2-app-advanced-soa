<?php

namespace backend\managers;

use backend\repository\items\PascalCaseRepository;
use backend\repository\items\UserRepository;

/**
 * < Common > Менеджер репозиториев
 *
 * @property-read \backend\repository\items\UserRepository $user
 * @property-read \backend\repository\items\PascalCaseRepository $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #repository
 */
class BackendRepositoryManager extends \common\managers\CommonServiceManager
{
    public const string USER = 'userRepository';
    public const string PASCALE_CASE = 'PascalCaseRepository';


    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        ...\common\managers\CommonServiceManager::CONFIG,
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