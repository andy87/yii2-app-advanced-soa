<?php declare(strict_types=1);

namespace yii2\frontend\components\resources\site;

use yii2\common\components\resources\TemplateResources;

/**
 * < Frontend > `SiteAboutResources`
 *
 * @package yii2\frontend\resources\site
 *
 * @tag #resources #site #about
 */
class SiteAboutResources extends TemplateResources
{
    /** @var string Шаблон */
    public const string TEMPLATE = '@app/views/site/about';
}