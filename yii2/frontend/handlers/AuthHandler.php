<?php

namespace yii2\frontend\handlers;

use Yii;
use yii\base\InvalidConfigException;
use yii2\common\components\Action;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\Auth;
use yii2\frontend\resources\auth\AuthLoginResources;
use yii2\frontend\resources\auth\AuthSignupResources;
use yii2\frontend\services\controllers\AuthService;

/**
 * @property-read AuthService $service;
 */
class AuthHandler extends \yii2\common\handlers\AuthHandler
{
    use LazyLoadTrait;

    public array $lazyLoadConfig = [
        'service' => AuthService::class,
    ];


    /**
     * @throws InvalidConfigException
     */
    public function processLogin(): AuthLoginResources
    {
        /** @var AuthLoginResources $R */
        $R = $this->getResource(Action::LOGIN );

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $this->service->authLoginForm( $R->loginForm, $post );
        }

        return $R;
    }

    /**
     * @return void
     */
    public function processLogout(): void
    {
        $this->service->logout();
    }

    /**
     * @return AuthSignupResources
     *
     * @throws InvalidConfigException
     */
    public function processSignup(): AuthSignupResources
    {
        /** @var AuthSignupResources $R */
        $R = $this->getResource(Auth::ACTION_SIGNUP );

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $this->service->handlerSignupForm( $R->signupForm, $post );
        }

        return $R;
    }
}