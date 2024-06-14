<?php declare(strict_types=1);

namespace app\frontend\controllers;

use Exception;
use Yii;
use app\common\models\LoginForm;
use yii\base\Exception as YiiBaseException;
use yii\db\Exception as YiiDbException;
use yii\filters\{VerbFilter, AccessControl};
use app\common\components\trair\SessionFlash;
use yii\web\{Response, BadRequestHttpException};
use app\frontend\services\controllers\AuthService;
use app\frontend\components\BaseFrontendController;
use yii\base\{InvalidArgumentException, InvalidConfigException};
use app\frontend\resources\auth\{AuthRequestPasswordResetResources,
    AuthResetPasswordResources,
    AuthSignupResources,
    AuthLoginResources
};
use app\frontend\models\forms\{SignupForm,
    VerifyEmailForm,
    ResetPasswordForm,
    ResendVerificationEmailForm,
    PasswordResetRequestForm
};

/**
 * Class `AuthController`
 *
 * @package app\frontend\controllers
 */
class AuthController extends BaseFrontendController
{
    use SessionFlash;

    public const ENDPOINT = 'auth';

    public const ACTION_LOGIN = 'login';
    public const ACTION_LOGOUT = 'logout';
    public const ACTION_SIGNUP = 'signup';
    public const ACTION_REQUEST_PASSWORD_RESET = 'request-password-reset';
    public const ACTION_RESET_PASSWORD = 'reset-password';
    public const ACTION_VERIFY_EMAIL = 'verify-email';
    public const ACTION_RESEND_VERIFICATION_EMAIL = 'resend-verification-email';
    public const ACTION_REQUEST_PASSWORD_RESET_TOKEN = 'request-password-reset-token';


    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [self::ACTION_LOGOUT, self::ACTION_SIGNUP],
                'rules' => [
                    [
                        'actions' => [self::ACTION_SIGNUP],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [self::ACTION_LOGOUT],
                        'allow' => true,
                        'roles' => ['@'],
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
     */
    public function actionIndex(): string
    {
        return $this->actionLogin();
    }

    /**
     * @return Response|string
     *
     * @throws InvalidConfigException
     */
    public function actionLogin(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            $R = new AuthLoginResources;

            $result = AuthService::getInstance()->handlerLoginForm($R->loginForm, Yii::$app->request->post());

            if ($result) {

                return $this->goBack();

            } else {

                $R->loginForm->password = '';

                return $this->render($R::TEMPLATE, $R->release());
            }

        } else {

            return $this->goHome();
        }
    }

    /**
     * Logs out the current user.
     *
     * @return Response|string
     *
     * @throws InvalidConfigException
     */
    public function actionLogout(): Response|string
    {
        AuthService::getInstance()->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return Response|string
     *
     * @throws InvalidConfigException
     */
    public function actionSignup(): Response|string
    {
        $R = new AuthSignupResources;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $handlerResult = AuthService::getInstance()->handlerSignupForm($R->signupForm, $post);

            $this->setSessionFlashMessage($handlerResult,
                $R->signupForm::MESSAGE_SUCCESS,
                $R->signupForm::MESSAGE_ERROR
            );

            if ($handlerResult) return $this->goHome();
        }

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * Requests password reset.
     *
     * @return Response|string
     *
     * @throws InvalidConfigException|InvalidConfigException|YiiBaseException|Exception
     */
    public function actionRequestPasswordReset(): Response|string
    {
        $R = new AuthRequestPasswordResetResources;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $handlerResult = AuthService::getInstance()
                ->handlerRequestPasswordResetResources($R->passwordResetRequestForm, $post);

            $this->setSessionFlashMessage($handlerResult,
                $R->passwordResetRequestForm::MESSAGE_SUCCESS,
                $R->passwordResetRequestForm::MESSAGE_ERROR);

            if ($handlerResult) return $this->goHome();
        }

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return Response|string
     *
     * @throws BadRequestHttpException|YiiBaseException
     */
    public function actionResetPassword(string $token): Response|string
    {
        $R = new AuthResetPasswordResources;

        $R->resetPasswordForm = new ResetPasswordForm($token);

        try
        {
            $post = Yii::$app->request->post();

            $result = AuthService::getInstance()
                ->handlerResetPasswordForm($R->resetPasswordForm, $post);

            $this->setSessionFlashMessage($result,
                $R->resetPasswordForm::MESSAGE_SUCCESS,
                $R->resetPasswordForm::MESSAGE_ERROR
            );

            if ($result) return $this->goHome();

            return $this->render($R::TEMPLATE, $R->release());

        } catch (InvalidArgumentException $e) {

            $this->runtimeLogError( __METHOD__,
                $e->getMessage(),
                $R->resetPasswordForm
            );

            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Verify email address
     *
     * @param string $token
     *
     * @return Response
     *
     * @throws BadRequestHttpException|YiiDbException
     */
    public function actionVerifyEmail(string $token): Response
    {
        try
        {
            $model = new VerifyEmailForm($token);

            if (($user = $model->verifyEmail()) && Yii::$app->user->login($user))
            {
                Yii::$app->session->setFlash('success', 'Вы успешно подтвердили свой email!');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Извините! Токен неверный, мы не можем подтвердить аккаунт.');

            return $this->goHome();

        } catch (InvalidArgumentException $e) {

            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Resend verification email
     *
     * @return Response|string
     */
    public function actionResendVerificationEmail(): Response|string
    {
        $model = new ResendVerificationEmailForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->sendEmail())
            {
                Yii::$app->session->setFlash('success', 'Проверьте свою почту для получения дальнейших инструкций.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Извините, мы не можем отправить письмо для подтверждения на указанный адрес электронной почты.');
        }

        return $this->render('resendVerificationEmail', [ 'model' => $model ]);
    }
}
