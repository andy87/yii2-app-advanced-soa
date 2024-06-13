<?php declare(strict_types=1);

namespace app\frontend\controllers;

use app\common\components\trair\SessionFlash;
use app\common\models\LoginForm;
use app\frontend\components\BaseFrontendController;
use app\frontend\models\forms\PasswordResetRequestForm;
use app\frontend\models\forms\ResendVerificationEmailForm;
use app\frontend\models\forms\ResetPasswordForm;
use app\frontend\models\forms\SignupForm;
use app\frontend\models\forms\VerifyEmailForm;
use app\frontend\resources\auth\AuthLoginResources;
use app\frontend\resources\auth\AuthSignupResources;
use app\frontend\services\controllers\AuthService;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Response;


/**
 * Site controller
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

            $R->loginForm = new LoginForm;

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
     * @throws InvalidConfigException
     */
    public function actionSignup(): Response|string
    {
        $R = new AuthSignupResources;

        $R->signupForm = new SignupForm;

        if (Yii::$app->request->isPost) {
            $result = AuthService::getInstance()->handlerSignupForm($R->signupForm, Yii::$app->request->post());

            if ($result)
            {
                $this->setSessionFlashSuccess($R->signupForm::MESSAGE_SUCCESS);

                return $this->goHome();

            } else {

                $this->setSessionFlashError($R->signupForm::MESSAGE_ERROR);
            }
        }

        return $this->render($R::TEMPLATE, $R->release());
    }

    /**
     * Requests password reset.
     *
     * @return Response|string
     */
    public function actionRequestPasswordReset(): Response|string
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return Response|string
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token): Response|string
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     *
     * @return Response
     *
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token): Response
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return Response|string
     */
    public function actionResendVerificationEmail(): Response|string
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
