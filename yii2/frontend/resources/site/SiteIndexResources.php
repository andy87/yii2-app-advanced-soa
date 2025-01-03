<?php declare(strict_types=1);

namespace frontend\resources\site;

use common\resources\TemplateResources;

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
    public const string TEMPLATE = '@app/views/site/index';
}