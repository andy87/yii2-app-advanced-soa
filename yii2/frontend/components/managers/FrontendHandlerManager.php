<?php

namespace yii2\frontend\components\managers;

use yii2\common\components\managers\CommonServiceManager;
use yii2\frontend\components\handlers\controllers\SiteHandler;
use yii2\frontend\components\handlers\items\PascalCaseHandler;

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
        self::SITE => ['class' => SiteHandler::class ],
        self::PASCALE_CASE => ['class' => PascalCaseHandler::class ],
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}