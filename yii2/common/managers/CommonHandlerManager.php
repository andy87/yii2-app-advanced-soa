<?php

namespace common\managers;

use common\services\items\PascalCaseService;
use common\components\base\managers\HandlerManager;


/**
 * < Common > Менеджер сервисов
 *

 * @property-read \common\services\items\PascalCaseService $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class CommonHandlerManager extends HandlerManager
{
    public const string PASCALE_CASE = 'PascalCaseHandler';


    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        self::PASCALE_CASE => ['class' => PascalCaseService::class ],
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}