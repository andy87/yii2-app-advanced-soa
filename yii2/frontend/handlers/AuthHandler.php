<?php

namespace yii2\frontend\handlers;

use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii2\common\components\Auth;
use yii2\common\components\Action;
use yii\base\InvalidConfigException;
use yii\base\InvalidArgumentException;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\traits\Logger;
use yii2\frontend\models\forms\VerifyEmailForm;
use yii2\frontend\models\forms\ResetPasswordForm;
use yii2\frontend\services\controllers\AuthService;
use yii2\frontend\resources\auth\AuthLoginResources;
use yii2\frontend\resources\auth\AuthSignupResources;
use yii2\frontend\resources\auth\AuthResetPasswordResources;
use yii2\frontend\resources\auth\AuthRequestPasswordResetResources;
use yii2\frontend\resources\auth\AuthResendVerificationEmailResources;

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
     * @return AuthLoginResources
     *
     * @throws Exception
     */
    public function processLogin(): AuthLoginResources
    {
        try
        {
            /** @var AuthLoginResources $R */
            $R = $this->getResource(Action::LOGIN );

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->authLoginForm( $R->loginForm, $post );
            }

            return $R;

        } catch ( Exception $e ) {

            Yii::error( $this->prepareException(__METHOD__, $e) );

            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return AuthSignupResources
     *
     * @throws Exception
     */
    public function processSignup(): AuthSignupResources
    {
        try
        {
            /** @var AuthSignupResources $R */
            $R = $this->getResource(Auth::ACTION_SIGNUP );

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->handlerSignupForm( $R->signupForm, $post );
            }

            return $R;

        } catch ( Exception $e ) {

            Yii::error( $this->prepareException(__METHOD__, $e) );

            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return AuthRequestPasswordResetResources
     *
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function processRequestPasswordReset(): AuthRequestPasswordResetResources
    {
        try
        {
            /** @var AuthRequestPasswordResetResources $R */
            $R = $this->getResource(Auth::ACTION_REQUEST_PASSWORD_RESET);

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->handlerRequestPasswordResetResources($R->passwordResetRequestForm, $post);
            }

            return $R;

        } catch ( Exception $e ) {

            Yii::error( $this->prepareException(__METHOD__, $e) );

            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $token
     *
     * @return AuthResetPasswordResources
     *
     * @throws Exception
     */
    public function processResetPassword( string $token ): AuthResetPasswordResources
    {
        try
        {
            /** @var AuthResetPasswordResources $R */
            $R = $this->getResource(Auth::ACTION_RESET_PASSWORD );

            $R->resetPasswordForm = new ResetPasswordForm($token);

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->handlerResetPasswordForm($R->resetPasswordForm, $post);
            }

            return $R;

        } catch ( Exception $e) {

            $log = $this->prepareException(__METHOD__, $e);
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

            return $this->service->handlerAuthVerifyEmailResources($verifyEmailForm);

        } catch (InvalidArgumentException $e) {

            $log = $this->prepareException(__METHOD__, $e);
            $log['token'] = $token;

            Yii::error( $log );

            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @return AuthResendVerificationEmailResources
     *
     * @throws Exception
     */
    public function processResendVerificationEmail(): AuthResendVerificationEmailResources
    {
        try
        {
            /** @var AuthResendVerificationEmailResources $R */
            $R = $this->getResource(Auth::ACTION_RESEND_VERIFICATION_EMAIL );

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $this->service->handlerResendVerificationEmail($R->resendVerificationEmailForm, $post);
            }

            return $R;

        } catch (InvalidArgumentException $e) {

            Yii::error( $this->prepareException(__METHOD__, $e) );

            throw new Exception($e->getMessage());
        }
    }
}