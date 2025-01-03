<?php declare(strict_types=1);

namespace frontend\controllers;

use frontend\handlers\controllers\SiteHandler;
use frontend\resources\site\{SiteContactResources};
use frontend\resources\site\SiteAboutResources;
use frontend\resources\site\SiteIndexResources;
use JsonException;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Response;
use common\components\Action;
use common\components\traits\SessionFlash;
use frontend\components\{actions\CaptchaAction, controllers\parents\FrontendController};

/**
 * < Frontend > `SiteController`
 *
 * @property \frontend\handlers\controllers\SiteHandler $handler
 *
 * @package yii2\frontend\controllers
 *
 * @tag #frontend #controllers #site
 */
class SiteController extends FrontendController
{
    use SessionFlash;

    public const string ENDPOINT = 'site';

    public const array TITLES = [
        Action::INDEX => 'Главная',
        self::ACTION_ABOUT => 'О нас',
        self::ACTION_CONTACT => 'Контакты',
    ];

    public array $resources = [
        Action::INDEX => SiteIndexResources::class,
        self::ACTION_ABOUT => SiteAboutResources::class,
        self::ACTION_CONTACT => SiteContactResources::class,
    ];

    public const string ACTION_CONTACT = 'contact';
    public const string ACTION_ABOUT = 'about';

    public function init(): void
    {
        parent::init();

        $this->handler = new \frontend\handlers\controllers\SiteHandler();
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

        /** @var \frontend\resources\site\SiteContactResources $R */
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
