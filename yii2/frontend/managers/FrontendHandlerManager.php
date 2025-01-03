<?php

namespace frontend\managers;

use frontend\handlers\controllers\SiteHandler;
use frontend\handlers\items\PascalCaseHandler;

/**
 * < Common > Менеджер сервисов
 *
 * @property-read \frontend\handlers\controllers\SiteHandler $site
 * @property-read \frontend\handlers\items\PascalCaseHandler $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class FrontendHandlerManager extends \common\managers\CommonServiceManager
{
    public const string SITE = 'siteHandler';
    public const string PASCALE_CASE = 'PascalCaseHandler';


    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        ...\common\managers\CommonServiceManager::CONFIG,
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