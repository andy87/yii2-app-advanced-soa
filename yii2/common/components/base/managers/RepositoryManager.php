<?php

namespace common\components\base\managers;

use common\components\base\managers\source\SourceManager;
use common\components\base\repository\items\source\SourceRepository;

/**
 * < Common > Менеджер репозиториев
 *
 * @method SourceRepository getItem($name)
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #repository
 */
abstract class RepositoryManager extends SourceManager
{
    /** @var string Тип */
    protected string $type = self::TYPE_REPOSITORY;
}