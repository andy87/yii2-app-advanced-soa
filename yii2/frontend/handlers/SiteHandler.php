<?php

namespace yii2\frontend\handlers;

use Yii;
use yii\base\InvalidConfigException;
use yii2\common\components\Action;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\Result;
use yii2\frontend\components\Site;
use yii2\frontend\viewModels\site\SiteAboutViewModel;
use yii2\frontend\viewModels\site\SiteContactViewModel;
use yii2\frontend\viewModels\site\SiteIndexViewModel;
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
     * @return SiteIndexViewModel
     */
    public function processIndex(): SiteIndexViewModel
    {
        /** @var SiteIndexViewModel $R */
        $R = $this->getResource(Action::INDEX);

        return $R;
    }

    /**
     * @return SiteContactViewModel
     *
     * @throws InvalidConfigException
     */
    public function processContact(): SiteContactViewModel
    {
        /** @var SiteContactViewModel $R */
        $R = $this->getResource(Site::ACTION_CONTACT);

        if ( Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $result = $this->service->handlerContactForm($R->contactForm, $post );

            $R->contactForm->result = $result ? Result::OK : Result::ERROR;
        }

        return $R;
    }

    /**
     * @return SiteAboutViewModel
     */
    public function processAbout(): SiteAboutViewModel
    {
        /** @var SiteAboutViewModel $R */
        $R = $this->getResource(Site::ACTION_ABOUT);

        return $R;
    }
}