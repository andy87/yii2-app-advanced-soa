<?php

namespace yii2\common\components\base\managers;

use yii2\common\components\base\managers\source\SourceManager;
use yii2\common\components\base\services\items\source\SourceService;

/**
 * < Common > Менеджер сервисов
 *
 * @method SourceService getItem($name)
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
abstract class ServiceManager extends SourceManager
{
    /** @var string Тип */
    protected string $type = self::TYPE_SERVICE;
}