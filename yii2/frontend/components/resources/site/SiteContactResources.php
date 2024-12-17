<?php declare(strict_types=1);

namespace yii2\frontend\components\resources\site;

use yii2\frontend\models\forms\ContactForm;
use yii2\common\components\resources\TemplateResources;

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