<?php declare(strict_types=1);

namespace yii2\frontend\controllers;

use Yii;
use Exception;
use yii\web\Response;
use RuntimeException;
use andy87\yii2dnk\domain\BaseDomain;
use yii2\common\components\Auth;
use yii2\common\components\Result;
use yii2\frontend\handlers\AuthHandler;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\frontend\domains\auth\AuthDomain;
use yii2\frontend\domains\auth\AuthHandler as DnkAuthHandler;
use yii2\frontend\models\forms\SignupForm;
use yii2\frontend\models\forms\VerifyEmailForm;
use yii2\common\components\traits\SessionFlash;
use yii2\frontend\models\forms\ResetPasswordForm;
use yii2\frontend\viewModels\auth\AuthLoginViewModel;
use yii2\frontend\viewModels\auth\AuthSignupViewModel;
use yii2\frontend\models\forms\PasswordResetRequestForm;
use yii2\frontend\models\forms\ResendVerificationEmailForm;
use yii2\frontend\viewModels\auth\AuthResetPasswordViewModel;
use yii2\frontend\components\controllers\BaseFrontendController;
use yii2\frontend\domains\auth\viewModels\AuthLoginViewModel as DnkAuthLoginViewModel;
use yii2\frontend\domains\auth\viewModels\AuthRequestPasswordResetViewModel as DnkAuthRequestPasswordResetViewModel;
use yii2\frontend\domains\auth\viewModels\AuthResendVerificationEmailViewModel as DnkAuthResendVerificationEmailViewModel;
use yii2\frontend\domains\auth\viewModels\AuthResetPasswordViewModel as DnkAuthResetPasswordViewModel;
use yii2\frontend\viewModels\auth\AuthRequestPasswordResetViewModel;
use yii2\frontend\viewModels\auth\AuthResendVerificationEmailViewModel;

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
                Auth::ACTION_LOGIN => AuthLoginViewModel::class,
                Auth::ACTION_SIGNUP => AuthSignupViewModel::class,
                Auth::ACTION_REQUEST_PASSWORD_RESET => AuthRequestPasswordResetViewModel::class,
                Auth::ACTION_RESET_PASSWORD => AuthResetPasswordViewModel::class,
                Auth::ACTION_RESEND_VERIFICATION_EMAIL => AuthResendVerificationEmailViewModel::class,
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
        $payload = AuthDomain::createPayload(Auth::ACTION_LOGIN, [
            'isPost' => Yii::$app->request->isPost,
            'formData' => Yii::$app->request->post(),
        ]);

        $R = $this->createDnkAuthHandler()->run($payload);

        if (!$R instanceof DnkAuthLoginViewModel) {
            throw new RuntimeException('DNK Auth login returned invalid view model.');
        }

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
        $payload = AuthDomain::createPayload(Auth::ACTION_REQUEST_PASSWORD_RESET, [
            'isPost' => Yii::$app->request->isPost,
            'formData' => Yii::$app->request->post(),
        ]);

        $dnkHandler = $this->createDnkAuthHandler();

        $R = Yii::$app->request->isPost
            ? $dnkHandler->runTransactional($payload)
            : $dnkHandler->run($payload);

        if (!$R instanceof DnkAuthRequestPasswordResetViewModel) {
            throw new RuntimeException('DNK Auth request-password-reset returned invalid view model.');
        }

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
        $payload = AuthDomain::createPayload(Auth::ACTION_RESET_PASSWORD, [
            'token' => $token,
            'isPost' => Yii::$app->request->isPost,
            'formData' => Yii::$app->request->post(),
        ]);

        $dnkHandler = $this->createDnkAuthHandler();

        $R = Yii::$app->request->isPost
            ? $dnkHandler->runTransactional($payload)
            : $dnkHandler->run($payload);

        if (!$R instanceof DnkAuthResetPasswordViewModel) {
            throw new RuntimeException('DNK Auth reset-password returned invalid view model.');
        }

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
     * Создаёт DNK handler домена Auth через пакетный Domain registry.
     *
     * @return DnkAuthHandler Handler login/reset-password сценариев.
     */
    private function createDnkAuthHandler(): DnkAuthHandler
    {
        $handler = AuthDomain::create(BaseDomain::HANDLER);

        if (!$handler instanceof DnkAuthHandler) {
            throw new RuntimeException(sprintf(
                'DNK Auth handler must be instance of "%s", "%s" given.',
                DnkAuthHandler::class,
                $handler::class
            ));
        }

        return $handler;
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
        $payload = AuthDomain::createPayload(Auth::ACTION_VERIFY_EMAIL, [
            'token' => $token,
        ]);

        $result = $this->createDnkAuthHandler()->runTransactional($payload);

        if (!is_bool($result)) {
            throw new RuntimeException('DNK Auth verify-email returned invalid result.');
        }

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
        $payload = AuthDomain::createPayload(Auth::ACTION_RESEND_VERIFICATION_EMAIL, [
            'isPost' => Yii::$app->request->isPost,
            'formData' => Yii::$app->request->post(),
        ]);

        $dnkHandler = $this->createDnkAuthHandler();

        $R = Yii::$app->request->isPost
            ? $dnkHandler->runTransactional($payload)
            : $dnkHandler->run($payload);

        if (!$R instanceof DnkAuthResendVerificationEmailViewModel) {
            throw new RuntimeException('DNK Auth resend-verification-email returned invalid view model.');
        }

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
