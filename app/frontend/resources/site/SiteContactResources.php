<?php declare(strict_types=1);

namespace app\frontend\resources\site;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\ContactForm;

/**
 * < Frontend > `SiteContactResources`
 *
 * @package app\frontend\resources\site
 *
 * @tag #resources #site #contact
 */
class SiteContactResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/site/contact';

    /** @var ContactForm */
    public ContactForm $contactForm;



    /**
     * SiteContactResources constructor.
     *
     * @return void
     *
     * @tag #resources #constructor
     */
    public function __construct()
    {
        $this->contactForm = new ContactForm;
    }
}