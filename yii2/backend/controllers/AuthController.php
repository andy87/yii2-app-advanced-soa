<?php declare(strict_types=1);

namespace backend\controllers;

use backend\resources\auth\AuthLoginResources;
use yii\{base\InvalidConfigException, web\Response};
use Yii;
use yii\filters\{AccessControl, VerbFilter};
use backend\components\controllers\parents\BackendController;
use common{components\Action, models\sources\Role};

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

                $handlerResult = \backend\services\controllers\AuthService::getInstance()->handlerLoginForm($R->loginForm, $post);

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
        \backend\services\controllers\AuthService::getInstance()->logout();

        return $this->goHome();
    }
}
