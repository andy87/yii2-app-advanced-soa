<?php declare(strict_types=1);

namespace yii2\frontend\resources\site;

use yii2\common\components\resources\TemplateResources;

/**
 * < Frontend > `SiteIndexResources`
 *
 * @package yii2\frontend\resources\site
 *
 * @tag #resources #site #index
 */
class SiteIndexResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/site/index';
}