<?php declare(strict_types=1);

namespace app\backend\controllers;

use Yii;
use yii\web\Response;
use yii\base\InvalidConfigException;
use app\common\components\{ Role, Action };
use yii\filters\{ VerbFilter, AccessControl };
use app\backend\services\controllers\AuthService;
use app\backend\resources\auth\AuthLoginResources;
use app\backend\components\controllers\BaseBackendController;

/**
 * < Backend > `AuthController`
 *
 * @package app\backend\controllers
 *
 * @tag #backend #controller #auth
 */
class AuthController extends BaseBackendController
{
    public const ENDPOINT = 'auth';



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

                $handlerResult = AuthService::getInstance()
                    ->handlerLoginForm($R->loginForm, $post);

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
        AuthService::getInstance()
            ->logout();

        return $this->goHome();
    }
}
