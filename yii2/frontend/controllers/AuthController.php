<?php declare(strict_types=1);

namespace yii2\frontend\controllers;

use Yii;
use Exception;
use yii\web\Response;
use yii2\common\components\Auth;
use yii2\common\components\Result;
use yii2\frontend\handlers\AuthHandler;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\frontend\models\forms\SignupForm;
use yii2\frontend\models\forms\VerifyEmailForm;
use yii2\common\components\traits\SessionFlash;
use yii2\frontend\models\forms\ResetPasswordForm;
use yii2\frontend\resources\auth\AuthLoginResources;
use yii2\frontend\resources\auth\AuthSignupResources;
use yii2\frontend\models\forms\PasswordResetRequestForm;
use yii2\frontend\models\forms\ResendVerificationEmailForm;
use yii2\frontend\resources\auth\AuthResetPasswordResources;
use yii2\frontend\components\controllers\BaseFrontendController;
use yii2\frontend\resources\auth\AuthRequestPasswordResetResources;
use yii2\frontend\resources\auth\AuthResendVerificationEmailResources;

/**
 * < Frontend > `AuthController`
 *
 * @property-read AuthHandler $handler;
 *
 * @package yii2\frontend\controllers
 *
 * @tag #controllers #auth
 */
class AuthController extends BaseFrontendController
{
    use SessionFlash, LazyLoadTrait;

    public const ENDPOINT = Auth::ENDPOINT;

    public const LABELS = Auth::LABELS;

    public array $lazyLoadConfig = [
        'handler' => [
            'class' => AuthHandler::class,
            'resources' => [
                Auth::ACTION_LOGIN => AuthLoginResources::class,
                Auth::ACTION_SIGNUP => AuthSignupResources::class,
                Auth::ACTION_REQUEST_PASSWORD_RESET => AuthRequestPasswordResetResources::class,
                Auth::ACTION_RESET_PASSWORD => AuthResetPasswordResources::class,
                Auth::ACTION_RESEND_VERIFICATION_EMAIL => AuthResendVerificationEmailResources::class,
            ]
        ]
    ];


    /**
     * @return array[]
     *
     * @tag #auth #behaviors
     */
    public function behaviors(): array
    {
        return Auth::BEHAVIORS;
    }

    /**
     * @return string
     *
     * @throws Exception
     *
     * @tag #auth #action #index
     */
    public function actionIndex(): string
    {
        return $this->actionLogin();
    }

    /**
     * @endpoint auth/login
     *
     * @return Response|string
     *
     * @throws Exception
     *
     * @tag #auth #action #login
     */
    public function actionLogin(): Response|string
    {
        $R = $this->handler->processLogin();

        if ( Yii::$app->user->isGuest )
        {
            return $this->render($R::TEMPLATE, $R->release());
        }

        return $this->goHome();
    }

    /**
     * @endpoint auth/logout
     *
     * @return Response|string
     *
     * @tag #auth #action #logout
     */
    public function actionLogout(): Response|string
    {
        $this->handler->processLogout();

        return $this->goHome();
    }

    /**
     * @endpoint auth/signup
     *
     * @return Response|string
     *
     * @throws Exception
     *
     * @tag #auth #action #signup
     */
    public function actionSignup(): Response|string
    {
        $R = $this->handler->processSignup();

        if ($R->signupForm->result)
        {
            $this->setSessionFlashMessage(
                ($R->signupForm->result === Result::OK),
                SignupForm::MESSAGE_SUCCESS,
                SignupForm::MESSAGE_ERROR
            );
        }

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * @endpoint auth/request-password-reset
     *
     * @return Response|string
     *
     * @throws Exception
     *
     * @tag #auth #action #requestPasswordReset
     */
    public function actionRequestPasswordReset(): Response|string
    {
        $R = $this->handler->processRequestPasswordReset();

        if ($R->passwordResetRequestForm->result)
        {
            $isOK = ($R->passwordResetRequestForm->result === Result::OK);

            $this->setSessionFlashMessage($isOK,
                PasswordResetRequestForm::MESSAGE_SUCCESS,
                PasswordResetRequestForm::MESSAGE_ERROR
            );

            if ($isOK) return $this->goHome();
        }

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * @endpoint auth/reset-password
     *
     * @param string $token
     *
     * @return Response|string
     *
     * @throws Exception
     *
     * @tag #auth #action #resetPassword
     */
    public function actionResetPassword( string $token ): Response|string
    {
        $R = $this->handler->processResetPassword($token);

        if (Yii::$app->request->isPost)
        {
            $isOK = ($R->resetPasswordForm->result == Result::OK);

            $this->setSessionFlashMessage($isOK,
                ResetPasswordForm::MESSAGE_SUCCESS,
                ResetPasswordForm::MESSAGE_ERROR
            );

            if ($isOK) return $this->goHome();
        }

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * @endpoint auth/verify-email
     *
     * @param string $token
     *
     * @return Response
     *
     * @throws Exception
     *
     * @tag #auth #action #verifyEmail
     */
    public function actionVerifyEmail( string $token ): Response
    {
        $result = $this->handler->processVerifyEmail( $token );

        $this->setSessionFlashMessage( $result,
            VerifyEmailForm::MESSAGE_SUCCESS,
            VerifyEmailForm::MESSAGE_ERROR
        );

        return $this->goHome();
    }

    /**
     * @endpoint auth/resend-verification-email
     *
     * @return Response|string
     *
     * @throws Exception
     *
     * @tag #auth #action #resendVerificationEmail
     */
    public function actionResendVerificationEmail(): Response|string
    {
        $R = $this->handler->processResendVerificationEmail();

        if ($R->resendVerificationEmailForm->result)
        {
            $isOK = ($R->resendVerificationEmailForm->result === Result::OK);

            $this->setSessionFlashMessage($isOK,
                ResendVerificationEmailForm::MESSAGE_SUCCESS,
                ResendVerificationEmailForm::MESSAGE_ERROR
            );

            if ($isOK) return $this->goHome();
        }

        return $this->render($R::TEMPLATE, $R->release());
    }
}
