<?php

namespace console\managers;

use common\managers\CommonHandlerManager;
use console\handlers\items\PascalCaseHandler;

/**
 * < Common > Менеджер сервисов
 *
 * @property-read \console\handlers\items\PascalCaseHandler $pascalCase
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
class ConsoleHandlerManager extends CommonHandlerManager
{
    public const string PASCALE_CASE = 'PascalCase';



    /**
     * Массив экземпляров сервисов
     *
     * @var array $_listInstance
     */
    public const array CONFIG = [
        ...CommonHandlerManager::CONFIG,
        self::PASCALE_CASE => ['class' => PascalCaseHandler::class ],
    ];



    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;
}