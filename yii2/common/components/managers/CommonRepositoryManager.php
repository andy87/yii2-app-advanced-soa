<?php

namespace yii2\common\components\managers;

use yii2\common\components\base\managers\RepositoryManager;
use yii2\common\components\repository\IdentityRepository;
use yii2\common\components\repository\items\UserRepository;
use yii2\common\components\repository\items\PascalCaseRepository;


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