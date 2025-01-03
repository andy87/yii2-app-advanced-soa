<?php declare(strict_types=1);

namespace frontend\controllers;

use common\components\AccessControl;
use Yii;
use Exception;
use yii\filters\VerbFilter;
use common\models\sources\Role;
use frontend\services\AuthService;
use yii\db\Exception as YiiDbException;
use common\components\traits\SessionFlash;
use frontend\resources\auth\AuthLoginResources;
use frontend\resources\auth\AuthSignupResources;
use frontend\resources\auth\AuthResetPasswordResources;
use frontend\resources\auth\AuthRequestPasswordResetResources;
use frontend\components\controllers\parents\FrontendController;
use frontend\resources\auth\AuthResendVerificationEmailResources;
use yii\base\{Exception as YiiBaseException, InvalidArgumentException, InvalidConfigException};
use yii\web\Response;

/**
 * < Frontend > `AuthController`
 *
 * @package yii2\frontend\controllers
 *
 * @tag #controllers #auth
 */
class AuthController extends FrontendController
{
    use SessionFlash;

    public const string ENDPOINT = 'auth';

    public const string ACTION_LOGIN = 'login';
    public const string ACTION_LOGOUT = 'logout';
    public const string ACTION_SIGNUP = 'signup';
    public const string ACTION_REQUEST_PASSWORD_RESET = 'request-password-reset';
    public const string ACTION_RESET_PASSWORD = 'reset-password';
    public const string ACTION_VERIFY_EMAIL = 'verify-email';
    public const string ACTION_RESEND_VERIFICATION_EMAIL = 'resend-verification-email';
    public const string ACTION_REQUEST_PASSWORD_RESET_TOKEN = 'request-password-reset-token';

    /**
     * @
     */
    public const array LABELS = [
        self::ACTION_LOGIN => 'Вход',
        self::ACTION_SIGNUP => 'Регистрация',
        self::ACTION_REQUEST_PASSWORD_RESET => 'Запрос сброса пароля',
        self::ACTION_RESET_PASSWORD => 'Сброс пароля',
        self::ACTION_VERIFY_EMAIL => 'Подтверждение email',
        self::ACTION_RESEND_VERIFICATION_EMAIL => 'Повторное подтверждение email',
        self::ACTION_REQUEST_PASSWORD_RESET_TOKEN => 'Запрос токена сброса пароля',
    ];



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
                'only' => [ self::ACTION_LOGIN, self::ACTION_LOGOUT, self::ACTION_SIGNUP],
                'rules' => [
                    [
                        'actions' => [
                            self::ACTION_LOGIN,
                            self::ACTION_SIGNUP
                        ],
                        'allow' => true,
                        'roles' => [AccessControl::GUEST],
                    ],
                    [
                        'actions' => [self::ACTION_LOGOUT],
                        'allow' => true,
                        'roles' => [AccessControl::USER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    self::ACTION_LOGOUT => ['post'],
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
     * @throws InvalidConfigException|Exception
     *
     * @tag #auth #action #signup
     */
    public function actionSignup(): Response|string
    {
        $R = new AuthSignupResources;

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $handlerResult = AuthService::getInstance()->handlerSignupForm( $R->signupForm, $post );

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
