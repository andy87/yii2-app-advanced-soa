<?php

namespace app\frontend\resources\site;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\ContactForm;

/**
 * Class `SiteContactResources`
 *
 * @package app\frontend\resources\site
 */
class SiteContactResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@views/site/contact';

    /** @var ContactForm */
    public ContactForm $contactForm;
}