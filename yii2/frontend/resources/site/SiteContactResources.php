<?php declare(strict_types=1);

namespace yii2\frontend\resources\site;

use yii2\common\components\resources\TemplateResources;
use yii2\frontend\models\forms\ContactForm;

/**
 * < Frontend > `SiteContactResources`
 *
 * @package yii2\frontend\resources\site
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