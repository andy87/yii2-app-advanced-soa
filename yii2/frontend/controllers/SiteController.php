<?php declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use JsonException;
use yii\web\Response;
use frontend\components\Navigation;
use common\components\enums\Action;
use yii\base\InvalidConfigException;
use common\components\traits\SessionFlash;
use frontend\handlers\controllers\SiteHandler;
use frontend\components\actions\CaptchaAction;
use frontend\resources\site\SiteAboutResources;
use frontend\resources\site\SiteIndexResources;
use frontend\resources\site\SiteContactResources;
use frontend\components\controllers\parents\FrontendController;

/**
 * < Frontend > `SiteController`
 *
 * @property SiteHandler $handler
 *
 * @package yii2\frontend\controllers
 *
 * @tag #frontend #controllers #site
 */
class SiteController extends FrontendController
{
    use SessionFlash;

    public const string ENDPOINT = 'site';


    public const string ACTION_CONTACT = 'contact';
    public const string ACTION_ABOUT = 'about';



    /**
     * @var string[]
     */
    public array $resources = [
        Navigation::INDEX => SiteIndexResources::class,
        Navigation::ABOUT => SiteAboutResources::class,
        Navigation::CONTACT => SiteContactResources::class,
    ];


    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->handler = new SiteHandler();
    }

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
            'fixedVerifyCode' => CaptchaAction::getFixedVerifyCode()
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
        $resourceClassName = $this->resources[Action::INDEX];

        $R = new $resourceClassName();

        return $this->render($R::TEMPLATE, $R->release() );
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     *
     * @throws InvalidConfigException|JsonException
     *
     * @tag #site #action #contact
     */
    public function actionContact(): Response|string
    {
        $resourceClassName = $this->resources[self::ACTION_CONTACT];

        /** @var SiteContactResources $R */
        $R = new $resourceClassName();

        if ( Yii::$app->request->isPost)
        {
            $params = Yii::$app->request->post();

            $result = $this->handler->processContactForm( $R->contactForm, $params );

            $this->setSessionFlashMessage( $result,
                $R->contactForm::MESSAGE_SUCCESS,
                $R->contactForm::MESSAGE_ERROR
            );

            if( $result )
            {
                return $this->refresh();
            }
        }

        return $this->render( $R::TEMPLATE, $R->release() );
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
