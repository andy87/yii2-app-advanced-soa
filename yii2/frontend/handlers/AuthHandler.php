<?php

namespace yii2\frontend\handlers;

use Yii;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii2\common\components\Action;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\Auth;
use yii2\frontend\models\forms\ResetPasswordForm;
use yii2\frontend\resources\auth\AuthLoginResources;
use yii2\frontend\resources\auth\AuthRequestPasswordResetResources;
use yii2\frontend\resources\auth\AuthResetPasswordResources;
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

    /**
     * @return AuthRequestPasswordResetResources
     *
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function processRequestPasswordReset(): AuthRequestPasswordResetResources
    {
        /** @var AuthRequestPasswordResetResources $R */
        $R = $this->getResource(Auth::ACTION_REQUEST_PASSWORD_RESET);

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $this->service->handlerRequestPasswordResetResources($R->passwordResetRequestForm, $post);
        }

        return $R;
    }

    /**
     * @param string $token
     *
     * @return AuthResetPasswordResources
     *
     * @throws BadRequestHttpException|InvalidConfigException|Exception
     */
    public function processResetPassword( string $token ): AuthResetPasswordResources
    {
        /** @var AuthResetPasswordResources $R */
        $R = $this->getResource(Auth::ACTION_RESET_PASSWORD );

        $R->resetPasswordForm = new ResetPasswordForm($token);

        try
        {
            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->handlerResetPasswordForm($R->resetPasswordForm, $post);

                $this->setSessionFlashMessage($result,
                    $R->resetPasswordForm::MESSAGE_SUCCESS,
                    $R->resetPasswordForm::MESSAGE_ERROR
                );

                if ($result) return $this->goHome();
            }

        } catch (InvalidArgumentException $e) {

            $this->runtimeLogError( $e->getMessage(),
                __METHOD__,
                $R->resetPasswordForm
            );

            throw new BadRequestHttpException($e->getMessage());
        }

        return $R;
    }
}