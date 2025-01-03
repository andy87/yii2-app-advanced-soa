<?php declare(strict_types=1);

namespace common\resources;

use yii2\common\components\base\resources\items\sources\SourceResource;

/**
 * < Common > `TemplateResources`
 *
 * @package yii2\common\components\resources
 */
abstract class TemplateResources extends SourceResource
{
    public const string TEMPLATE = 'index';
}