<?php

namespace common\components\base\managers;

use common\components\base\managers\source\SourceManager;
use common\components\base\services\items\source\SourceService;

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