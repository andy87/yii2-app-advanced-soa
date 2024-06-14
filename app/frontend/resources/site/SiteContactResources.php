<?php

namespace app\frontend\resources\site;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\ContactForm;

/**
 * Class `SiteContactResources`
 *
 * @package app\frontend\resources\site
 *
 * @tag #resources #site #contact
 */
class SiteContactResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@views/site/contact';

    /** @var ContactForm */
    public ContactForm $contactForm;



    /**
     * SiteContactResources constructor.
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->contactForm = new ContactForm;
    }
}