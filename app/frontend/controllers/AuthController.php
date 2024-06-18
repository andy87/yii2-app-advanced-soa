<?php declare(strict_types=1);

namespace app\frontend\controllers;

use Yii;
use Exception;
use app\common\models\Identity;
use app\frontend\services\AuthService;
use yii\db\Exception as YiiDbException;
use app\common\components\{ Role , Action };
use yii\filters\{ AccessControl, VerbFilter };
use app\common\components\traits\SessionFlash;
use yii\web\{ BadRequestHttpException, Response };
use app\frontend\components\controllers\BaseFrontendController;
use app\frontend\models\forms\{ ResetPasswordForm, VerifyEmailForm };
use yii\base\{ Exception as YiiBaseException, InvalidArgumentException, InvalidConfigException };
use app\frontend\resources\auth\{AuthLoginResources, AuthRequestPasswordResetResources, AuthResendVerificationEmailResources, AuthResetPasswordResources, AuthSignupResources };

/**
 * < Frontend > `AuthController`
 *
 * @package app\frontend\controllers
 *
 * @tag #controllers #auth
 */
class AuthController extends BaseFrontendController
{
    use SessionFlash;

    public const ENDPOINT = 'auth';


    public const ACTION_SIGNUP = 'signup';
    public const ACTION_REQUEST_PASSWORD_RESET = 'request-password-reset';
    public const ACTION_RESET_PASSWORD = 'reset-password';
    public const ACTION_VERIFY_EMAIL = 'verify-email';
    public const ACTION_RESEND_VERIFICATION_EMAIL = 'resend-verification-email';
    public const ACTION_REQUEST_PASSWORD_RESET_TOKEN = 'request-password-reset-token';



    /**
     * @return array[]
     *
     * @tag #auth #behaviors
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [ Action::LOGIN, Action::LOGOUT, self::ACTION_SIGNUP],
                'rules' => [
                    [
                        'actions' => [
                            Action::LOGIN,
                            self::ACTION_SIGNUP,
                            self::ACTION_REQUEST_PASSWORD_RESET,
                            self::ACTION_RESET_PASSWORD,
                            self::ACTION_VERIFY_EMAIL,
                            self::ACTION_RESEND_VERIFICATION_EMAIL,
                            self::ACTION_REQUEST_PASSWORD_RESET_TOKEN
                        ],
                        'allow' => true,
                        'roles' => [Role::GUEST],
                    ],
                    [
                        'actions' => [Action::LOGOUT],
                        'allow' => true,
                        'roles' => [Role::USER],
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
        if (Yii::$app->user->isGuest)
        {
            $R = new AuthLoginResources;

            if (Yii::$app->request->isPost)
            {
                $post = Yii::$app->request->post();

                $handlerResult = AuthService::getInstance()->handlerLoginForm($R->loginForm, $post);

                if ($handlerResult) return $this->goBack();
            }

        } else {

            return $this->goHome();
        }

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * @endpoint auth/logout
     *
     * @return Response|string
     *
     * @throws InvalidConfigException
     *
     * @tag #auth #action #logout
     */
    public function actionLogout(): Response|string
    {
        AuthService::getInstance()->logout();

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
        $R = new AuthSignupResources;

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $handlerResult = AuthService::getInstance()->handlerSignupForm($R->signupForm, $post);

            $this->setSessionFlashMessage(
                ($handlerResult instanceof Identity),
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

            $this->runtimeLogError( __METHOD__,
                $e->getMessage(),
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
        $verifyEmailForm = new VerifyEmailForm($token);

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
