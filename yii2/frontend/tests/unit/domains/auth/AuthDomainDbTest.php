<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\domains\auth;

use Codeception\Test\Unit;
use yii2\common\components\Auth;
use yii2\common\components\Result;
use yii2\frontend\domains\auth\AuthDomain;
use yii2\frontend\domains\auth\AuthRepository;
use yii2\frontend\domains\auth\AuthService;
use yii2\frontend\domains\auth\payloads\AuthResetPasswordPayload;
use yii2\frontend\models\forms\ResetPasswordForm;

/**
 * DB-интеграционные тесты DNK AuthDomain.
 *
 * Запускаются только в окружении с PostgreSQL PDO driver.
 */
class AuthDomainDbTest extends Unit
{
    /**
     * Проверяет, что AuthRepository может выполнить DB-запрос.
     *
     * @return void
     */
    public function testRepositoryCanQueryActiveUser(): void
    {
        if (!extension_loaded('pdo_pgsql')) {
            $this->markTestSkipped('ext-pdo_pgsql is not installed in current PHP runtime.');
        }

        $repository = new AuthRepository();

        $this->assertNull($repository->findActiveByUsername('__missing_user__'));
        $this->assertNull($repository->findActiveByEmail('__missing_user__@example.test'));
    }

    /**
     * Проверяет DB-запросы verification/reset-token сценариев.
     *
     * @return void
     */
    public function testRepositoryCanQueryVerificationAndResetTokens(): void
    {
        if (!extension_loaded('pdo_pgsql')) {
            $this->markTestSkipped('ext-pdo_pgsql is not installed in current PHP runtime.');
        }

        $repository = new AuthRepository();

        $this->assertNull($repository->findInactiveByEmail('__missing_user__@example.test'));
        $this->assertNull($repository->findInactiveByVerificationToken('__missing_verification_token__'));
        $this->assertNull($repository->findByPasswordResetToken('__missing_reset_token__'));
    }

    /**
     * Проверяет, что reset-password service читает token через AuthRepository.
     *
     * @return void
     * @throws \yii\base\Exception Если генерация password hash/auth key завершилась ошибкой.
     */
    public function testResetPasswordServiceUsesRepositoryForMissingToken(): void
    {
        if (!extension_loaded('pdo_pgsql')) {
            $this->markTestSkipped('ext-pdo_pgsql is not installed in current PHP runtime.');
        }

        /** @var AuthResetPasswordPayload $payload */
        $payload = AuthDomain::createPayload(Auth::ACTION_RESET_PASSWORD, [
            'token' => '__missing_reset_token__',
            'isPost' => true,
            'formData' => [
                'ResetPasswordForm' => [
                    ResetPasswordForm::ATTR_PASSWORD => 'new-password',
                ],
            ],
        ]);

        $form = new ResetPasswordForm($payload->token, [], false);
        $service = new AuthService();

        $this->assertFalse($service->resetPassword($form, $payload));
        $this->assertSame(Result::ERROR, $form->result);
        $this->assertTrue($form->hasErrors(ResetPasswordForm::ATTR_PASSWORD));
    }
}
