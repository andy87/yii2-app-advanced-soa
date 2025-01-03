<?php declare(strict_types=1);

namespace backend\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use common\components\AccessControl;
use yii\base\InvalidConfigException;
use common\components\enums\Endpoints;
use backend\services\controllers\AuthService;
use backend\resources\auth\AuthLoginResources;
use backend\components\controllers\parents\BackendController;

/**
 * < Backend > `AuthController`
 *
 * @package yii2\backend\controllers
 *
 * @tag #backend #controller #auth
 */
class AuthController extends BackendController
{
    public const string ENDPOINT = 'auth';

    public const array LABELS = [
        Endpoints::LOGIN => 'Авторизация',
    ];


    /**
     * {@inheritdoc}
     *
     * @return array
     *
     * @tag #backend #controller #behaviors
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [Endpoints::LOGIN, Endpoints::ERROR ],
                        'allow' => true,
                        'roles' => [ AccessControl::ROLE_GUEST ],
                    ],
                    [
                        'actions' => [Endpoints::LOGOUT ],
                        'allow' => true,
                        'roles' => [ AccessControl::ROLE_USER ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    Endpoints::LOGOUT => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return Response|string
     *
     * @throws InvalidConfigException
     *
     * @tag #backend #site #login
     */
    public function actionLogin(): Response|string
    {
        if (Yii::$app->user->isGuest)
        {
            $this->layout = 'blank';

            $R = new AuthLoginResources;

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $handlerResult = AuthService::getInstance()->handlerLoginForm($R->loginForm, $post);

                if ($handlerResult) return $this->goBack();
            }

            return $this->render($R::TEMPLATE, $R->release());
        }

        return $this->goHome();
    }

    /**
     * @return Response
     *
     * @throws InvalidConfigException
     *
     * @tag #backend #site #logout
     */
    public function actionLogout(): Response
    {
        AuthService::getInstance()->logout();

        return $this->goHome();
    }
}
