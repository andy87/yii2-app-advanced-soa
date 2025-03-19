<?php declare(strict_types=1);

namespace yii2\backend\controllers;

use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii2\common\components\Action;
use yii\base\InvalidConfigException;
use yii2\common\components\Auth;
use yii2\common\models\sources\Role;
use yii2\backend\handlers\AuthHandler;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\backend\resources\auth\AuthLoginResources;
use yii2\backend\components\controllers\BaseBackendController;

/**
 * < Backend > `AuthController`
 *
 * @property-read AuthHandler $handler
 *
 * @package yii2\backend\controllers
 *
 * @tag #backend #controller #auth
 */
class AuthController extends BaseBackendController
{
    use LazyLoadTrait;

    public const ENDPOINT = 'auth';

    public const LABELS = [
        Auth::ACTION_LOGIN => 'Авторизация',
    ];


    public array $lazyLoadConfig = [
        'handler' => [
            'class' => AuthHandler::class,
            'resources' => [
                Auth::ACTION_LOGIN => AuthLoginResources::class,
            ]
        ]
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
                        'actions' => [ Auth::ACTION_LOGIN ],
                        'allow' => true,
                        'roles' => [ Role::GUEST ],
                    ],
                    [
                        'actions' => [ Auth::ACTION_LOGOUT ],
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
                    Auth::ACTION_LOGOUT => ['post'],
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

        $R = $this->handler->processLogin();
        if ($R->loginForm->result) return $this->goBack();

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
        $this->handler->processLogout();

        return $this->goHome();
    }
}
