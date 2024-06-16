<?php declare(strict_types=1);

namespace app\frontend\controllers;

use Yii;
use yii\web\Response;
use yii\base\InvalidConfigException;
use app\frontend\services\SiteService;
use app\frontend\models\forms\ContactForm;
use app\common\components\traits\SessionFlash;
use app\frontend\components\{actions\CaptchaAction, controllers\BaseFrontendController};
use app\frontend\resources\site\{SiteAboutResources, SiteContactResources, SiteIndexResources};

/**
 * < Frontend > `SiteController`
 *
 * @package app\frontend\controllers
 *
 * @tag #frontend #controllers #site
 */
class SiteController extends BaseFrontendController
{
    use SessionFlash;


    /**
     * @return array
     *
     * @tag #site #actionEditor
     */
    public function actions(): array
    {
        $actions = parent::actions();

        return $this->addActionCaptcha($actions);
    }

    /**
     * @param array $actions
     *
     * @return array
     *
     * @tag #site #actionAdd
     */
    private function addActionCaptcha( array $actions ): array
    {
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

        $R->contactForm = new ContactForm;

        $result = SiteService::getInstance()
            ->handlerContactForm($R->contactForm, Yii::$app->request->post() );

        if( $result === null )
        {
            $this->setSessionFlashError( $R->contactForm::MESSAGE_ERROR );
            return $this->refresh();

        } else {

            $this->setSessionFlashMessage(
                $result,
                $R->contactForm::MESSAGE_SUCCESS,
                $R->contactForm::MESSAGE_ERROR
            );
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
