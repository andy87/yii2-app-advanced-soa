<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth;

use andy87\yii2dnk\domain\BaseDomain;
use yii2\common\components\Auth;
use yii2\common\models\Identity;
use yii2\frontend\domains\auth\payloads\AuthLoginPayload;
use yii2\frontend\domains\auth\payloads\AuthRequestPasswordResetPayload;
use yii2\frontend\domains\auth\payloads\AuthResendVerificationEmailPayload;
use yii2\frontend\domains\auth\payloads\AuthResetPasswordPayload;
use yii2\frontend\domains\auth\payloads\AuthVerifyEmailPayload;
use yii2\frontend\domains\auth\viewModels\AuthLoginViewModel;
use yii2\frontend\domains\auth\viewModels\AuthRequestPasswordResetViewModel;
use yii2\frontend\domains\auth\viewModels\AuthResendVerificationEmailViewModel;
use yii2\frontend\domains\auth\viewModels\AuthResetPasswordViewModel;

/**
 * DNK registry домена авторизации frontend-приложения.
 *
 * Связывает пакетные DNK-слои Auth: Handler, Service, Repository, Producer,
 * Killer, Payload и ViewModel для вертикальной миграции web auth-сценариев.
 */
class AuthDomain extends BaseDomain
{
    protected string $model = Identity::class;

    protected string $service = AuthService::class;

    protected string $repository = AuthRepository::class;

    protected string $producer = AuthProducer::class;

    protected string $killer = AuthKiller::class;

    protected string $handler = AuthHandler::class;

    protected array $payloads = [
        Auth::ACTION_LOGIN => AuthLoginPayload::class,
        Auth::ACTION_REQUEST_PASSWORD_RESET => AuthRequestPasswordResetPayload::class,
        Auth::ACTION_RESET_PASSWORD => AuthResetPasswordPayload::class,
        Auth::ACTION_RESEND_VERIFICATION_EMAIL => AuthResendVerificationEmailPayload::class,
        Auth::ACTION_VERIFY_EMAIL => AuthVerifyEmailPayload::class,
    ];

    protected array $viewModels = [
        Auth::ACTION_LOGIN => AuthLoginViewModel::class,
        Auth::ACTION_REQUEST_PASSWORD_RESET => AuthRequestPasswordResetViewModel::class,
        Auth::ACTION_RESET_PASSWORD => AuthResetPasswordViewModel::class,
        Auth::ACTION_RESEND_VERIFICATION_EMAIL => AuthResendVerificationEmailViewModel::class,
    ];
}
