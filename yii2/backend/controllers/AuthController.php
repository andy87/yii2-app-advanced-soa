<?php declare(strict_types=1);

namespace yii2\backend\controllers;

use Yii;
use yii\filters\{AccessControl, VerbFilter};
use yii\{base\InvalidConfigException, web\Response};
use yii2\common\{components\Action, models\sources\Role};
use yii2\backend\components\resources\auth\AuthLoginResources;
use yii2\backend\components\controllers\parents\BackendController;
use yii2\backend\components\services\controllers\AuthService;

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
        Action::LOGIN => 'Авторизация',
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
                        'actions' => [Action::LOGIN, Action::ERROR ],
                        'allow' => true,
                    ],
                    [
                        'actions' => [Action::LOGOUT ],
                        'allow' => true,
                        'roles' => [ Role::USER ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    Action::LOGOUT => ['post'],
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
