<?php declare(strict_types=1);

namespace yii2\frontend\controllers;

use Yii;
use Exception;
use andy87\lazy_load\LazyLoadTrait;
use yii\base\{Exception as YiiBaseException, InvalidArgumentException, InvalidConfigException};
use yii\db\Exception as YiiDbException;
use yii\web\{BadRequestHttpException, Response};
use yii2\common\{components\Action, components\Auth, models\Identity};
use yii2\common\components\traits\SessionFlash;
use yii2\frontend\components\controllers\BaseFrontendController;
use yii2\frontend\models\forms\{ResetPasswordForm, VerifyEmailForm};
use yii2\frontend\resources\auth\{AuthLoginResources,
    AuthRequestPasswordResetResources,
    AuthResendVerificationEmailResources,
    AuthResetPasswordResources,
    AuthSignupResources};
use yii2\frontend\handlers\AuthHandler;
use yii2\frontend\services\controllers\AuthService;

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
                Action::LOGIN => AuthLoginResources::class,
                Auth::ACTION_SIGNUP => AuthSignupResources::class,
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
     * @throws InvalidConfigException
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
     * @throws InvalidConfigException
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
     * @throws InvalidConfigException
     *
     * @tag #auth #action #signup
     */
    public function actionSignup(): Response|string
    {
        $R = $this->handler->processSignup();

        if (Yii::$app->request->isPost)
        {
            $this->setSessionFlashMessage(
                ($R->signupForm->result),
                $R->signupForm::MESSAGE_SUCCESS,
                $R->signupForm::MESSAGE_ERROR
            );
        }

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * @endpoint auth/request-password-reset
     *
     * @return Response|string
     *
     * @throws InvalidConfigException|InvalidConfigException|YiiBaseException|Exception
     *
     * @see PasswordResetRequestFormTest
     *
     * @tag #auth #action #requestPasswordReset
     */
    public function actionRequestPasswordReset(): Response|string
    {
        $R = new AuthRequestPasswordResetResources;

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $handlerResult = AuthService::getInstance()->handlerRequestPasswordResetResources($R->passwordResetRequestForm, $post);

            $this->setSessionFlashMessage($handlerResult,
                $R->passwordResetRequestForm::MESSAGE_SUCCESS,
                $R->passwordResetRequestForm::MESSAGE_ERROR
            );

            if ($handlerResult) return $this->goHome();
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
     * @throws BadRequestHttpException|YiiBaseException
     *
     * @see ResetPasswordFormTest
     *
     * @tag #auth #action #resetPassword
     */
    public function actionResetPassword(string $token): Response|string
    {
        $R = new AuthResetPasswordResources;

        $R->resetPasswordForm = new ResetPasswordForm($token);

        try
        {
            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $result = AuthService::getInstance()->handlerResetPasswordForm($R->resetPasswordForm, $post);

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

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * @endpoint auth/verify-email
     *
     * @param string $token
     *
     * @return Response
     *
     * @throws BadRequestHttpException|InvalidConfigException|YiiDbException
     *
     * @tag #auth #action #verifyEmail
     */
    public function actionVerifyEmail(string $token): Response
    {
        try {
            $verifyEmailForm = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        try
        {
            $handlerResult = AuthService::getInstance()->handlerAuthVerifyEmailResources($verifyEmailForm);

            $this->setSessionFlashMessage( $handlerResult,
                $verifyEmailForm::MESSAGE_SUCCESS,
                $verifyEmailForm::MESSAGE_ERROR
            );

        } catch (InvalidArgumentException $e) {

            throw new BadRequestHttpException($e->getMessage());
        }

        return $this->goHome();
    }

    /**
     * @endpoint auth/resend-verification-email
     *
     * @return Response|string
     *
     * @throws InvalidConfigException
     *
     * @tag #auth #action #resendVerificationEmail
     */
    public function actionResendVerificationEmail(): Response|string
    {
        $R = new AuthResendVerificationEmailResources;

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $handlerResult = AuthService::getInstance()->handlerResendVerificationEmail($R->resendVerificationEmailForm, $post);

            $this->setSessionFlashMessage($handlerResult,
                $R->resendVerificationEmailForm::MESSAGE_SUCCESS,
                $R->resendVerificationEmailForm::MESSAGE_ERROR
            );

            if ($handlerResult) return $this->goHome();
        }

        return $this->render($R::TEMPLATE, $R->release());
    }
}
