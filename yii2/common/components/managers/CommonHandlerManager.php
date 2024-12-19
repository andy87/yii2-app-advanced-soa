<?php

namespace yii2\common\components\managers;

use yii2\common\components\base\managers\HandlerManager;
use yii2\common\components\services\items\PascalCaseService;


/**
 * < Common > Менеджер сервисов
 *

 * @property-read PascalCaseService $pascalCase
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