<?php declare(strict_types=1);

namespace app\frontend\controllers;

use Yii;
use yii\web\Response;
use yii\base\InvalidConfigException;
use app\frontend\models\forms\ContactForm;
use app\common\components\traits\SessionFlash;
use app\frontend\services\controllers\SiteService;
use app\frontend\components\{actions\CaptchaAction, BaseFrontendController};
use app\frontend\resources\site\{SiteAboutResources, SiteContactResources, SiteIndexResources};

/**
 * Class `SiteController`
 *
 * @package app\frontend\controllers
 */
class SiteController extends BaseFrontendController
{
    use SessionFlash;



    /**
     * {@inheritdoc}
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
     */
    public function actionAbout(): string
    {
        $R = new SiteAboutResources();

        return $this->render($R::TEMPLATE);
    }
}
