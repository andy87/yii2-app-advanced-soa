<?php

namespace frontend\handlers\controllers;

use frontend\services\SiteService;
use JsonException;
use yii\base\InvalidConfigException;
use yii2\common\components\base\handlers\items\source\SourceHandler;
use yii2\frontend\models\forms\ContactForm;

/**
 * < Frontend > `SiteHandler`
 *
 * @property-read \frontend\services\SiteService $service
 *
 * @package yii2\frontend\components\handlers\controllers
 *
 * @tag #frontend #handler #site
 */
class SiteHandler extends SourceHandler
{
    /**
     * @param ContactForm $contactForm
     *
     * @param array $params
     *
     * @return bool
     *
     * @throws InvalidConfigException|JsonException
     */
    public function processContactForm( ContactForm $contactForm, array $params ): bool
    {
        if ( $contactForm->load($params) && $contactForm->validate() )
        {
            return $this->service->sendContactFormToAdminEmail( $contactForm );
        }

        return false;
    }
}