<?php

namespace yii2\common\components\base\managers;

use yii2\common\components\base\managers\source\SourceManager;
use yii2\common\components\base\handlers\items\source\SourceHandler;

/**
 * < Common > Менеджер обработчиков
 *
 * @method SourceHandler getItem($name)
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #handler
 */
abstract class HandlerManager extends SourceManager
{
    /** @var string Тип */
    protected string $type = self::TYPE_HANDLER;
}