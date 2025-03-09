<?php declare(strict_types=1);

namespace yii2\backend\controllers;

use Yii;
use yii\filters\{ VerbFilter, AccessControl };
use yii\{ web\Response, base\InvalidConfigException };
use yii2\common\{ components\Action, models\sources\Role };
use yii2\backend\{ services\controllers\AuthService, resources\auth\AuthLoginResources, components\controllers\BaseBackendController };

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
                        'actions' => [ Action::LOGIN ],
                        'allow' => true,
                        'roles' => [ Role::GUEST ],
                    ],
                    [
                        'actions' => [ Action::LOGOUT ],
                        'allow' => true,
                        'roles' => [ Role::USER ],
                    ],
                    [
                        'actions' => [ Action::ERROR ],
                        'allow' => true,
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
