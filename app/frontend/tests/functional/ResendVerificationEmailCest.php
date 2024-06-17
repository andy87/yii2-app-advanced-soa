<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\common\fixtures\UserFixture;
use app\frontend\tests\FunctionalTester;
use app\frontend\controllers\AuthController;
use app\frontend\models\forms\ResendVerificationEmailForm;
use Codeception\Exception\ModuleException;

/**
 * < Frontend > `ResendVerificationEmailCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
 *
 * Fix not used:
 * - @see ResendVerificationEmailCest::checkPage()
 * - @see ResendVerificationEmailCest::checkEmptyField()
 * - @see ResendVerificationEmailCest::checkWrongEmailFormat()
 * - @see ResendVerificationEmailCest::checkWrongEmail()
 * - @see ResendVerificationEmailCest::checkAlreadyVerifiedEmail()
 * - @see ResendVerificationEmailCest::checkSendSuccessfully()
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ResendVerificationEmailCest
 *
 * @tag #frontend #tests #functional #ResendVerificationEmailCest
 */
class ResendVerificationEmailCest
{
    /** @var string $formId */
    protected string $formId = ResendVerificationEmailForm::ID;


    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    /**
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ResendVerificationEmailCest #_before
     */
    public function _before(FunctionalTester $I): void
    {
        /** @see AuthController::actionResendVerificationEmail() */
        $I->amOnRoute('/auth/resend-verification-email');
    }

    /**
     * @param string $email
     *
     * @return array
     */
    protected function formParams( string $email): array
    {
        return [
            'ResendVerificationEmailForm[email]' => $email
        ];
    }

    /**
     * Check page
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ResendVerificationEmailCest:checkPage
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ResendVerificationEmailCest.php#L42
     *
     * @param FunctionalTester $I
     *
     * @return void
     */
    public function checkPage(FunctionalTester $I): void
    {
        $I->see('Resend verification email', 'h1');
        $I->see('Please fill out your email. A verification email will be sent there.');
    }

    /**
     * Check empty field
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ResendVerificationEmailCest:checkEmptyField
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ResendVerificationEmailCest.php#L48
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ResendVerificationEmailCest #checkEmptyField
     */
    public function checkEmptyField(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, $this->formParams(''));
        $I->seeValidationError('Email cannot be blank.');
    }

    /**
     * Check wrong email format
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ResendVerificationEmailCest:checkWrongEmailFormat
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ResendVerificationEmailCest.php#L54
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ResendVerificationEmailCest #checkWrongEmailFormat
     */
    public function checkWrongEmailFormat(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, $this->formParams('abcd.com'));
        $I->seeValidationError('Email is not a valid email address.');
    }

    /**
     * Check wrong email
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ResendVerificationEmailCest:checkWrongEmail
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ResendVerificationEmailCest.php#L60
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ResendVerificationEmailCest #checkWrongEmail
     */
    public function checkWrongEmail(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, $this->formParams('wrong@email.com'));
        $I->seeValidationError('There is no user with this email address.');
    }

    /**
     * Check already verified email
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ResendVerificationEmailCest:checkAlreadyVerifiedEmail
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ResendVerificationEmailCest.php#L66
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ResendVerificationEmailCest #checkAlreadyVerifiedEmail
     */
    public function checkAlreadyVerifiedEmail(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, $this->formParams('test2@mail.com'));
        $I->seeValidationError('There is no user with this email address.');
    }

    /**
     * Check send successfully
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ResendVerificationEmailCest:checkSendSuccessfully
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ResendVerificationEmailCest.php#L72
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @throws ModuleException
     *
     * @tag #frontend #tests #functional #ResendVerificationEmailCest #checkSendSuccessfully
     */
    public function checkSendSuccessfully(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, $this->formParams('test@mail.com'));
        $I->canSeeEmailIsSent();
        $I->seeRecord('app\common\models\Identity', [
            'email' => 'test@mail.com',
            'username' => 'test.test',
            'status' => \app\common\models\Identity::STATUS_INACTIVE
        ]);
        $I->see('Check your email for further instructions.');
    }
}
