<?php declare(strict_types=1);

namespace common\components\base\resources\items;

use common\components\base\resources\items\sources\SourceResource;

/**
 * < Common > Base class for all resources with template
 *
 * @package yii2\common\components\base\resources
 *
 * @tag: #abstract #common #resource #base #items
 */
abstract class BaseTemplateResource extends SourceResource
{
    /** @var string Title */
    public string $title;

    /** @var string Template name for rendering */
    public string $template;
}