<?php declare(strict_types=1);

namespace yii2\backend\controllers;

use Yii;
use yii\{base\InvalidConfigException, web\Response};
use yii\filters\{AccessControl, VerbFilter};
use yii2\backend\{components\controllers\BaseBackendController, components\resources\auth\AuthLoginResources};
use yii2\common\{components\Action, models\sources\Role};

/**
 * < Backend > `AuthController`
 *
 * @package yii2\backend\controllers
 *
 * @tag #backend #controller #auth
 */
class AuthController extends BaseBackendController
{
    public const ENDPOINT = 'auth';

    public const LABELS = [
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

                $handlerResult = \yii2\backend\components\services\controllers\AuthService::getInstance()->handlerLoginForm($R->loginForm, $post);

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
        \yii2\backend\components\services\controllers\AuthService::getInstance()->logout();

        return $this->goHome();
    }
}
