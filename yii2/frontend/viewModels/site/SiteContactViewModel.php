<?php declare(strict_types=1);

namespace yii2\frontend\viewModels\site;

use yii2\common\components\viewModels\TemplateViewModel;
use yii2\frontend\models\forms\ContactForm;

/**
 * < Frontend > `SiteContactViewModels`
 *
 * @package yii2\frontend\viewModels\site
 *
 * @tag #viewModel #site #contact
 */
class SiteContactViewModel extends TemplateViewModel
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/site/contact';

    /** @var ContactForm */
    public ContactForm $contactForm;



    /**
     * SiteContactViewModels constructor.
     *
     * @return void
     *
     * @tag #viewModel #constructor
     */
    public function __construct()
    {
        $this->contactForm = new ContactForm;
    }
}