<?php

namespace frontend\managers;

use frontend\repository\items\PascalCaseRepository;
use frontend\repository\items\UserRepository;

/**
 * < Common > Менеджер репозиториев
 *
 * @property-read \frontend\repository\items\UserRepository $user
 * @property-read \frontend\repository\items\PascalCaseRepository $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #repository
 */
class FrontendRepositoryManager extends \common\managers\CommonServiceManager
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