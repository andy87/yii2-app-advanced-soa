<?php declare(strict_types=1);

namespace yii2\frontend\controllers;

use yii\web\Response;
use yii2\common\components\Action;
use yii2\common\components\Result;
use yii2\frontend\components\Site;
use yii\base\InvalidConfigException;
use yii2\frontend\handlers\SiteHandler;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\frontend\models\forms\ContactForm;
use yii2\common\components\traits\SessionFlash;
use yii2\frontend\components\actions\CaptchaAction;
use yii2\frontend\resources\site\SiteAboutResources;
use yii2\frontend\resources\site\SiteIndexResources;
use yii2\frontend\resources\site\SiteContactResources;
use yii2\frontend\components\controllers\BaseFrontendController;

/**
 * < Frontend > `SiteController`
 *
 * @property-read SiteHandler $handler
 *
 * @package yii2\frontend\controllers
 *
 * @tag #frontend #controllers #site
 */
class SiteController extends BaseFrontendController
{
    use SessionFlash, LazyLoadTrait;


    public const ENDPOINT = 'site';

    public const LABELS = Site::LABELS;

    public array $lazyLoadConfig = [
        'handler' => [
            'class' => SiteHandler::class,
            'resources' => [
                Action::INDEX => SiteIndexResources::class,
                Site::ACTION_CONTACT => SiteContactResources::class,
                Site::ACTION_ABOUT => SiteAboutResources::class,
            ]
        ]
    ];



    /**
     * @return array
     *
     * @tag #site #actionEditor
     */
    public function actions(): array
    {
        $actions = parent::actions();

        $actions['captcha'] = [
            'class' => CaptchaAction::class,
            'fixedVerifyCode' => YII_ENV_TEST ? CaptchaAction::TEST_VALUE : null,
        ];

        return $actions;
    }

    /**
     * Displays homepage.
     *
     * @return string
     *
     * @tag #site #action #index
     */
    public function actionIndex(): string
    {
        $R = $this->handler->processIndex();

        return $this->render($R::TEMPLATE);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     *
     * @throws InvalidConfigException
     *
     * @tag #site #action #contact
     */
    public function actionContact(): Response|string
    {
        $R = $this->handler->processContact();

        if ( $R->contactForm->result )
        {
            $isOK = $R->contactForm->result === Result::OK;

            $this->setSessionFlashMessage( $isOK, ContactForm::MESSAGE_SUCCESS, ContactForm::MESSAGE_ERROR );

            if( $isOK ) return $this->refresh();
        }

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * Displays about page.
     *
     * @return string
     *
     * @tag #site #action #about
     */
    public function actionAbout(): string
    {
        $R = $this->handler->processAbout();

        return $this->render($R::TEMPLATE);
    }
}
