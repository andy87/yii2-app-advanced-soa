<?php

namespace yii2\frontend\handlers;

use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii2\common\components\Auth;
use yii\base\InvalidConfigException;
use yii\base\InvalidArgumentException;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\traits\Logger;
use yii2\frontend\models\forms\VerifyEmailForm;
use yii2\frontend\models\forms\ResetPasswordForm;
use yii2\frontend\services\controllers\AuthService;
use yii2\frontend\viewModels\auth\AuthLoginViewModel;
use yii2\frontend\viewModels\auth\AuthSignupViewModel;
use yii2\frontend\viewModels\auth\AuthResetPasswordViewModel;
use yii2\frontend\viewModels\auth\AuthRequestPasswordResetViewModel;
use yii2\frontend\viewModels\auth\AuthResendVerificationEmailViewModel;

/**
 * @property-read AuthService $service;
 */
class AuthHandler extends \yii2\common\handlers\AuthHandler
{
    use LazyLoadTrait, Logger;

    public array $lazyLoadConfig = [
        'service' => AuthService::class,
    ];


    /**
     * @return AuthLoginViewModel
     *
     * @throws Exception
     */
    public function processLogin(): AuthLoginViewModel
    {
        try
        {
            /** @var AuthLoginViewModel $R */
            $R = $this->getResource(Auth::ACTION_LOGIN );

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->authLoginForm( $R->loginForm, $post );
            }

            return $R;

        } catch ( Exception $e ) {

            Yii::error( $this->getPrepareException(__METHOD__, $e) );

            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return AuthSignupViewModel
     *
     * @throws Exception
     */
    public function processSignup(): AuthSignupViewModel
    {
        try
        {
            /** @var AuthSignupViewModel $R */
            $R = $this->getResource(Auth::ACTION_SIGNUP );

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->handlerSignupForm( $R->signupForm, $post );
            }

            return $R;

        } catch ( Exception $e ) {

            Yii::error( $this->getPrepareException(__METHOD__, $e) );

            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return AuthRequestPasswordResetViewModel
     *
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function processRequestPasswordReset(): AuthRequestPasswordResetViewModel
    {
        try
        {
            /** @var AuthRequestPasswordResetViewModel $R */
            $R = $this->getResource(Auth::ACTION_REQUEST_PASSWORD_RESET);

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->handlerRequestPasswordResetViewModels($R->passwordResetRequestForm, $post);
            }

            return $R;

        } catch ( Exception $e ) {

            Yii::error( $this->getPrepareException(__METHOD__, $e) );

            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $token
     *
     * @return AuthResetPasswordViewModel
     *
     * @throws Exception
     */
    public function processResetPassword( string $token ): AuthResetPasswordViewModel
    {
        try
        {
            /** @var AuthResetPasswordViewModel $R */
            $R = $this->getResource(Auth::ACTION_RESET_PASSWORD );

            $R->resetPasswordForm = new ResetPasswordForm($token);

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->handlerResetPasswordForm($R->resetPasswordForm, $post);
            }

            return $R;

        } catch ( Exception $e) {

            $log = $this->getPrepareException(__METHOD__, $e);
            $log['token'] = $token;

            Yii::error( $log );

            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $token
     *
     * @return bool
     *
     * @throws Exception
     */
    public function processVerifyEmail( string $token ): bool
    {
        try {

            $verifyEmailForm = new VerifyEmailForm( $token );

            return $this->service->handlerAuthVerifyEmailViewModels($verifyEmailForm);

        } catch (InvalidArgumentException $e) {

            $log = $this->getPrepareException(__METHOD__, $e);
            $log['token'] = $token;

            Yii::error( $log );

            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @return AuthResendVerificationEmailViewModel
     *
     * @throws Exception
     */
    public function processResendVerificationEmail(): AuthResendVerificationEmailViewModel
    {
        try
        {
            /** @var AuthResendVerificationEmailViewModel $R */
            $R = $this->getResource(Auth::ACTION_RESEND_VERIFICATION_EMAIL );

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->handlerResendVerificationEmail($R->resendVerificationEmailForm, $post);
            }

            return $R;

        } catch (InvalidArgumentException $e) {

            Yii::error( $this->getPrepareException(__METHOD__, $e) );

            throw new Exception($e->getMessage());
        }
    }
}