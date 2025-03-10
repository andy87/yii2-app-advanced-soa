<?php

namespace yii2\frontend\handlers;

use Yii;
use yii\base\InvalidConfigException;
use yii2\common\components\Action;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\Result;
use yii2\frontend\components\Site;
use yii2\frontend\resources\site\SiteAboutResources;
use yii2\frontend\resources\site\SiteContactResources;
use yii2\frontend\resources\site\SiteIndexResources;
use yii2\frontend\services\controllers\SiteService;
use yii2\common\components\handlers\TemplateHandler;

/**
 * @property-read SiteService $service
 */
class SiteHandler extends TemplateHandler
{
    use LazyLoadTrait;

    public array $lazyLoadConfig = [
        'service' => SiteService::class
    ];

    /**
     * @return SiteIndexResources
     */
    public function processIndex(): SiteIndexResources
    {
        /** @var SiteIndexResources $R */
        $R = $this->getResource(Action::INDEX);

        return $R;
    }

    /**
     * @return SiteContactResources
     *
     * @throws InvalidConfigException
     */
    public function processContact(): SiteContactResources
    {
        /** @var SiteContactResources $R */
        $R = $this->getResource(Site::ACTION_CONTACT);

        if ( Yii::$app->request->isPost)
        {
            $result = $this->service->handlerContactForm($R->contactForm, Yii::$app->request->post() );

            $R->contactForm->result = $result ? Result::OK : Result::ERROR;
        }

        return $R;
    }

    /**
     * @return SiteAboutResources
     */
    public function processAbout(): SiteAboutResources
    {
        /** @var SiteAboutResources $R */
        $R = $this->getResource(Site::ACTION_ABOUT);

        return $R;
    }
}