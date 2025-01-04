<?php

namespace common\managers;

use common\repository\IdentityRepository;
use common\repository\items\UserRepository;
use common\repository\items\PascalCaseRepository;
use common\components\base\managers\RepositoryManager;

/**
 * < Common > Менеджер сервисов
 *
 * @property-read UserRepository $user
 * @property-read IdentityRepository $identity
 * @property-read PascalCaseRepository $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class CommonRepositoryManager extends RepositoryManager
{
    public const string USER = 'user';
    public const string IDENTITY = 'identity';
    public const string PASCALE_CASE = 'PascalCase';



    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        self::USER => UserRepository::class,
        self::IDENTITY => IdentityRepository::class,
        self::PASCALE_CASE => PascalCaseRepository::class,
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}