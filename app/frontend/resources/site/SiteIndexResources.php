<?php

namespace app\frontend\resources\site;

use app\common\components\resources\TemplateResources;

/**
 * < Frontend > `SiteIndexResources`
 *
 * @package app\frontend\resources\site
 *
 * @tag #resources #site #index
 */
class SiteIndexResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@views/site/index';
}