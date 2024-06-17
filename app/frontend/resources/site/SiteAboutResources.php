<?php declare(strict_types=1);

namespace app\frontend\resources\site;

use app\common\components\resources\TemplateResources;

/**
 * < Frontend > `SiteAboutResources`
 *
 * @package app\frontend\resources\site
 *
 * @tag #resources #site #about
 */
class SiteAboutResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/site/about';
}