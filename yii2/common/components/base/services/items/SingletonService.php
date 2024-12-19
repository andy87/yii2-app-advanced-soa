<?php

namespace yii2\common\components\base\services\items;

use yii2\common\components\traits\SingletonTrait;
use yii2\common\components\base\services\items\source\SourceService;

/**
 * < Common > Родительский абстрактный класс для Singleton сервисов
 *
 * @package app\common\components\base\services\items\base
 *
 * @tag: #abstract #common #service #base
 */
abstract class SingletonService extends SourceService
{
    use SingletonTrait;
}