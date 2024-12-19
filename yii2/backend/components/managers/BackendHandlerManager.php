<?php

namespace yii2\backend\components\managers;

use yii2\common\components\managers\CommonServiceManager;
use yii2\backend\components\handlers\items\PascalCaseHandler;

/**
 * < Common > Менеджер обработчиков
 *
 * @property-read PascalCaseHandler $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class BackendHandlerManager extends CommonServiceManager
{
    public const string SITE = 'siteHandler';
    public const string PASCALE_CASE = 'PascalCaseHandler';


    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        ...CommonServiceManager::CONFIG,
        self::PASCALE_CASE => ['class' => PascalCaseHandler::class ],
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}