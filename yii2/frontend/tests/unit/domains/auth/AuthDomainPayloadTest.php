<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\domains\auth;

use Codeception\Test\Unit;
use andy87\yii2dnk\domain\BaseDomain;
use andy87\yii2dnk\exceptions\ValidationException;
use yii2\common\components\Auth;
use yii2\common\components\Result;
use yii2\frontend\domains\auth\AuthDomain;
use yii2\frontend\domains\auth\AuthHandler;
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
 * DB-free smoke-тесты DNK AuthDomain.
 *
 * Проверяют payload/viewModel/handler wiring без обращения к PostgreSQL.
 */
class AuthDomainPayloadTest extends Unit
{
    /**
     * Проверяет registry definitions AuthDomain.
     *
     * @return void
     */
    public function testDomainDefinitions(): void
    {
        $this->assertSame(AuthHandler::class, AuthDomain::definition(BaseDomain::HANDLER));
        $this->assertSame(AuthLoginPayload::class, AuthDomain::payloadClass(Auth::ACTION_LOGIN));
        $this->assertSame(AuthResetPasswordPayload::class, AuthDomain::payloadClass(Auth::ACTION_RESET_PASSWORD));
        $this->assertSame(AuthRequestPasswordResetPayload::class, AuthDomain::payloadClass(Auth::ACTION_REQUEST_PASSWORD_RESET));
        $this->assertSame(AuthResendVerificationEmailPayload::class, AuthDomain::payloadClass(Auth::ACTION_RESEND_VERIFICATION_EMAIL));
        $this->assertSame(AuthVerifyEmailPayload::class, AuthDomain::payloadClass(Auth::ACTION_VERIFY_EMAIL));
    }

    /**
     * Проверяет GET login flow без обращения к БД.
     *
     * @return void
     */
    public function testLoginGetHandlerWithoutDb(): void
    {
        $payload = AuthDomain::createPayload(Auth::ACTION_LOGIN, [
            'isPost' => false,
            'formData' => [],
        ]);

        $handler = AuthDomain::create(BaseDomain::HANDLER);
        $result = $handler->run($payload);

        $this->assertInstanceOf(AuthLoginViewModel::class, $result);
        $this->assertArrayHasKey('R', $result->release());
    }

    /**
     * Проверяет POST login validation без обращения к БД.
     *
     * @return void
     */
    public function testLoginPostEmptyDataWithoutDb(): void
    {
        $payload = AuthDomain::createPayload(Auth::ACTION_LOGIN, [
            'isPost' => true,
            'formData' => [],
        ]);

        $handler = AuthDomain::create(BaseDomain::HANDLER);
        $result = $handler->run($payload);

        $this->assertInstanceOf(AuthLoginViewModel::class, $result);
        $this->assertSame(Result::ERROR, $result->loginForm->result);
        $this->assertTrue($result->loginForm->hasErrors());
    }

    /**
     * Проверяет GET request-password-reset flow без обращения к БД.
     *
     * @return void
     */
    public function testRequestPasswordResetGetHandlerWithoutDb(): void
    {
        $payload = AuthDomain::createPayload(Auth::ACTION_REQUEST_PASSWORD_RESET, [
            'isPost' => false,
            'formData' => [],
        ]);

        $result = AuthDomain::create(BaseDomain::HANDLER)->run($payload);

        $this->assertInstanceOf(AuthRequestPasswordResetViewModel::class, $result);
        $this->assertArrayHasKey('R', $result->release());
    }

    /**
     * Проверяет POST request-password-reset validation без обращения к БД.
     *
     * @return void
     */
    public function testRequestPasswordResetPostEmptyDataWithoutDb(): void
    {
        $payload = AuthDomain::createPayload(Auth::ACTION_REQUEST_PASSWORD_RESET, [
            'isPost' => true,
            'formData' => [],
        ]);

        $result = AuthDomain::create(BaseDomain::HANDLER)->run($payload);

        $this->assertInstanceOf(AuthRequestPasswordResetViewModel::class, $result);
        $this->assertSame(Result::ERROR, $result->passwordResetRequestForm->result);
        $this->assertTrue($result->passwordResetRequestForm->hasErrors());
    }

    /**
     * Проверяет GET resend-verification-email flow без обращения к БД.
     *
     * @return void
     */
    public function testResendVerificationEmailGetHandlerWithoutDb(): void
    {
        $payload = AuthDomain::createPayload(Auth::ACTION_RESEND_VERIFICATION_EMAIL, [
            'isPost' => false,
            'formData' => [],
        ]);

        $result = AuthDomain::create(BaseDomain::HANDLER)->run($payload);

        $this->assertInstanceOf(AuthResendVerificationEmailViewModel::class, $result);
        $this->assertArrayHasKey('R', $result->release());
    }

    /**
     * Проверяет POST resend-verification-email validation без обращения к БД.
     *
     * @return void
     */
    public function testResendVerificationEmailPostEmptyDataWithoutDb(): void
    {
        $payload = AuthDomain::createPayload(Auth::ACTION_RESEND_VERIFICATION_EMAIL, [
            'isPost' => true,
            'formData' => [],
        ]);

        $result = AuthDomain::create(BaseDomain::HANDLER)->run($payload);

        $this->assertInstanceOf(AuthResendVerificationEmailViewModel::class, $result);
        $this->assertSame(Result::ERROR, $result->resendVerificationEmailForm->result);
        $this->assertTrue($result->resendVerificationEmailForm->hasErrors());
    }

    /**
     * Проверяет payload reset-password и verify-email без запуска DB use-case.
     *
     * @return void
     */
    public function testTokenPayloadsWithoutDb(): void
    {
        $resetPayload = AuthDomain::createPayload(Auth::ACTION_RESET_PASSWORD, [
            'token' => 'token',
            'isPost' => false,
            'formData' => [],
        ]);

        $verifyPayload = AuthDomain::createPayload(Auth::ACTION_VERIFY_EMAIL, [
            'token' => 'token',
        ]);

        $this->assertInstanceOf(AuthResetPasswordPayload::class, $resetPayload);
        $this->assertInstanceOf(AuthVerifyEmailPayload::class, $verifyPayload);
        $this->assertSame(AuthResetPasswordViewModel::class, AuthDomain::viewModelClass(Auth::ACTION_RESET_PASSWORD));
    }

    /**
     * Проверяет POST reset-password validation без обращения к БД.
     *
     * @return void
     */
    public function testResetPasswordPostEmptyDataWithoutDb(): void
    {
        $payload = AuthDomain::createPayload(Auth::ACTION_RESET_PASSWORD, [
            'token' => 'token',
            'isPost' => true,
            'formData' => [],
        ]);

        $result = AuthDomain::create(BaseDomain::HANDLER)->run($payload);

        $this->assertInstanceOf(AuthResetPasswordViewModel::class, $result);
        $this->assertSame(Result::ERROR, $result->resetPasswordForm->result);
        $this->assertTrue($result->resetPasswordForm->hasErrors());
    }

    /**
     * Проверяет validation verify-email payload без обращения к БД.
     *
     * @return void
     */
    public function testVerifyEmailPayloadValidationWithoutDb(): void
    {
        $this->expectException(ValidationException::class);

        AuthDomain::createPayload(Auth::ACTION_VERIFY_EMAIL, [
            'token' => '',
        ]);
    }
}
