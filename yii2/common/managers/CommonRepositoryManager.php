<?php

namespace common\managers;

use common\repository\IdentityRepository;
use common\repository\items\PascalCaseRepository;
use common\repository\items\UserRepository;
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
    public const string USER = 'userService';
    public const string IDENTITY = 'identityService';
    public const string PASCALE_CASE = 'PascalCaseService';


    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        self::USER => ['class' => UserRepository::class ],
        self::IDENTITY => ['class' => IdentityRepository::class ],
        self::PASCALE_CASE => ['class' => PascalCaseRepository::class ],
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}