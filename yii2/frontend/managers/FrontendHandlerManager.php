<?php

namespace frontend\managers;

use common\managers\CommonServiceManager;
use frontend\handlers\controllers\SiteHandler;
use frontend\handlers\items\PascalCaseHandler;

/**
 * < Common > Менеджер сервисов
 *
 * @property-read SiteHandler $site
 * @property-read PascalCaseHandler $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class FrontendHandlerManager extends CommonServiceManager
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
        self::SITE => SiteHandler::class,
        self::PASCALE_CASE => PascalCaseHandler::class,
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}