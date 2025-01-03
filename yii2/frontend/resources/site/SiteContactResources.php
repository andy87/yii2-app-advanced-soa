<?php declare(strict_types=1);

namespace frontend\resources\site;

use common\resources\TemplateResources;
use frontend\models\forms\ContactForm;

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
    public const string TEMPLATE = '@app/views/site/contact';

    /** @var ContactForm */
    public ContactForm $contactForm;



    /**
     * SiteContactResources constructor.
     *
     * @return void
     *
     * @tag #resources #constructor
     */
    public function __construct( array $config = [] )
    {
        parent::__construct( $config );

        $this->contactForm = new ContactForm;
    }
}