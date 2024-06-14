<?php

namespace app\frontend\resources\site;

use app\common\components\resources\TemplateResources;

/**
 * Class `SiteIndexResources`
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