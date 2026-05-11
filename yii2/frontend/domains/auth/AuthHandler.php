<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth;

use RuntimeException;
use andy87\yii2dnk\BasePayload;
use andy87\yii2dnk\domain\BaseHandler;
use andy87\yii2dnk\viewModels\BaseViewModel;
use yii\base\InvalidConfigException;
use yii2\frontend\domains\auth\payloads\AuthLoginPayload;
use yii2\frontend\domains\auth\payloads\AuthRequestPasswordResetPayload;
use yii2\frontend\domains\auth\payloads\AuthResendVerificationEmailPayload;
use yii2\frontend\domains\auth\payloads\AuthResetPasswordPayload;
use yii2\frontend\domains\auth\payloads\AuthVerifyEmailPayload;
use yii2\frontend\domains\auth\viewModels\AuthLoginViewModel;
use yii2\frontend\domains\auth\viewModels\AuthRequestPasswordResetViewModel;
use yii2\frontend\domains\auth\viewModels\AuthResendVerificationEmailViewModel;
use yii2\frontend\domains\auth\viewModels\AuthResetPasswordViewModel;
use yii2\frontend\models\forms\PasswordResetRequestForm;
use yii2\frontend\models\forms\ResendVerificationEmailForm;
use yii2\frontend\models\forms\ResetPasswordForm;

/**
 * DNK handler домена авторизации.
 *
 * Оркестрирует use-case login/reset-password: принимает payload, создаёт view-model
 * через Domain registry и вызывает бизнес-операции сервиса.
 */
class AuthHandler extends BaseHandler
{
    protected const DOMAIN = AuthDomain::class;

    /**
     * Маршрутизирует payload в конкретный use-case домена Auth.
     *
     * @param BasePayload $payload Входной DNK payload.
     * @param BaseViewModel|null $viewModel View-model из Domain registry.
     * @return BaseViewModel|bool|array|null Результат use-case.
     * @throws InvalidConfigException Если payload/view-model не поддерживается.
     * @throws \yii\base\Exception Если reset-password не смог сгенерировать hash/auth key.
     */
    protected function provider(BasePayload $payload, ?BaseViewModel $viewModel = null): BaseViewModel|bool|array|null
    {
        return match ($payload::class) {
            AuthLoginPayload::class => $this->processLogin($payload, $viewModel),
            AuthRequestPasswordResetPayload::class => $this->processRequestPasswordReset($payload, $viewModel),
            AuthResetPasswordPayload::class => $this->processResetPassword($payload, $viewModel),
            AuthResendVerificationEmailPayload::class => $this->processResendVerificationEmail($payload, $viewModel),
            AuthVerifyEmailPayload::class => $this->processVerifyEmail($payload),
            default => throw new InvalidConfigException(sprintf('Unsupported auth payload "%s".', $payload::class)),
        };
    }

    /**
     * Выполняет login use-case.
     *
     * @param AuthLoginPayload $payload Payload формы входа.
     * @param BaseViewModel|null $viewModel View-model, созданная registry.
     * @return AuthLoginViewModel View-model для render.
     * @throws InvalidConfigException Если view-model или service имеют неверный тип.
     */
    private function processLogin(AuthLoginPayload $payload, ?BaseViewModel $viewModel): AuthLoginViewModel
    {
        if (!$viewModel instanceof AuthLoginViewModel) {
            throw new InvalidConfigException('Auth login view model is not configured.');
        }

        $this->authService()->login($viewModel->loginForm, $payload);

        return $viewModel;
    }

    /**
     * Выполняет request-password-reset use-case.
     *
     * @param AuthRequestPasswordResetPayload $payload Payload запроса сброса пароля.
     * @param BaseViewModel|null $viewModel View-model, созданная registry.
     * @return AuthRequestPasswordResetViewModel View-model для render.
     * @throws InvalidConfigException Если view-model или service имеют неверный тип.
     * @throws \yii\base\Exception Если token не смог сгенерироваться.
     */
    private function processRequestPasswordReset(
        AuthRequestPasswordResetPayload $payload,
        ?BaseViewModel $viewModel
    ): AuthRequestPasswordResetViewModel {
        if (!$viewModel instanceof AuthRequestPasswordResetViewModel) {
            throw new InvalidConfigException('Auth request-password-reset view model is not configured.');
        }

        $viewModel->passwordResetRequestForm = new PasswordResetRequestForm();
        $this->authService()->requestPasswordReset($viewModel->passwordResetRequestForm, $payload);

        return $viewModel;
    }

    /**
     * Выполняет reset-password use-case.
     *
     * @param AuthResetPasswordPayload $payload Payload формы нового пароля.
     * @param BaseViewModel|null $viewModel View-model, созданная registry.
     * @return AuthResetPasswordViewModel View-model для render.
     * @throws InvalidConfigException Если view-model или service имеют неверный тип.
     * @throws \yii\base\Exception Если reset-password не смог сгенерировать hash/auth key.
     */
    private function processResetPassword(AuthResetPasswordPayload $payload, ?BaseViewModel $viewModel): AuthResetPasswordViewModel
    {
        if (!$viewModel instanceof AuthResetPasswordViewModel) {
            throw new InvalidConfigException('Auth reset-password view model is not configured.');
        }

        $viewModel->resetPasswordForm = new ResetPasswordForm($payload->token, [], false);
        $this->authService()->resetPassword($viewModel->resetPasswordForm, $payload);

        return $viewModel;
    }

    /**
     * Выполняет resend-verification-email use-case.
     *
     * @param AuthResendVerificationEmailPayload $payload Payload повторной отправки подтверждения.
     * @param BaseViewModel|null $viewModel View-model, созданная registry.
     * @return AuthResendVerificationEmailViewModel View-model для render.
     * @throws InvalidConfigException Если view-model или service имеют неверный тип.
     */
    private function processResendVerificationEmail(
        AuthResendVerificationEmailPayload $payload,
        ?BaseViewModel $viewModel
    ): AuthResendVerificationEmailViewModel {
        if (!$viewModel instanceof AuthResendVerificationEmailViewModel) {
            throw new InvalidConfigException('Auth resend-verification-email view model is not configured.');
        }

        $viewModel->resendVerificationEmailForm = new ResendVerificationEmailForm();
        $this->authService()->resendVerificationEmail($viewModel->resendVerificationEmailForm, $payload);

        return $viewModel;
    }

    /**
     * Выполняет verify-email use-case.
     *
     * @param AuthVerifyEmailPayload $payload Payload подтверждения email.
     * @return bool True, если email подтверждён.
     * @throws InvalidConfigException Если service имеет неверный тип.
     */
    private function processVerifyEmail(AuthVerifyEmailPayload $payload): bool
    {
        return $this->authService()->verifyEmail($payload);
    }

    /**
     * Возвращает service домена Auth с проверкой типа.
     *
     * @return AuthService Service бизнес-операций Auth.
     */
    private function authService(): AuthService
    {
        $service = $this->getService();

        if (!$service instanceof AuthService) {
            throw new RuntimeException(sprintf(
                'Auth service must be instance of "%s", "%s" given.',
                AuthService::class,
                $service::class
            ));
        }

        return $service;
    }
}
