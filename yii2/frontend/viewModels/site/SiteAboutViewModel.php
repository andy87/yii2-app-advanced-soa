<?php declare(strict_types=1);

namespace yii2\frontend\viewModels\site;

use yii2\common\components\viewModels\TemplateViewModel;

/**
 * < Frontend > `SiteAboutViewModels`
 *
 * @package yii2\frontend\viewModels\site
 *
 * @tag #viewModel #site #about
 */
class SiteAboutViewModel extends TemplateViewModel
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/site/about';
}