<?php declare(strict_types=1);

namespace yii2\frontend\controllers;

use Yii;
use yii\web\Response;
use yii2\common\components\Action;
use yii\base\InvalidConfigException;
use yii2\frontend\services\SiteService;
use yii2\common\components\traits\SessionFlash;
use yii2\frontend\components\{actions\CaptchaAction, controllers\BaseFrontendController};
use yii2\frontend\resources\site\{SiteAboutResources, SiteContactResources, SiteIndexResources};

/**
 * < Frontend > `SiteController`
 *
 * @package yii2\frontend\controllers
 *
 * @tag #frontend #controllers #site
 */
class SiteController extends BaseFrontendController
{
    use SessionFlash;

    public const ENDPOINT = 'site';
    public const ACTION_CONTACT = 'contact';
    public const ACTION_ABOUT = 'about';
    public const LABELS = [
        Action::INDEX => 'Главная',
        self::ACTION_ABOUT => 'О нас',
        self::ACTION_CONTACT => 'Контакты',
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
        $R = new SiteIndexResources;

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
        $R = new SiteContactResources;

        if ( Yii::$app->request->isPost)
        {
            $result = SiteService::getInstance()->handlerContactForm($R->contactForm, Yii::$app->request->post() );

            $this->setSessionFlashMessage( $result,
                $R->contactForm::MESSAGE_SUCCESS,
                $R->contactForm::MESSAGE_ERROR
            );

            if( $result ) return $this->refresh();
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
        $R = new SiteAboutResources();

        return $this->render($R::TEMPLATE);
    }
}
