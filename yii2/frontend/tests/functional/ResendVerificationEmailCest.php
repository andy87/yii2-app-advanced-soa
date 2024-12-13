<?php declare(strict_types=1);

namespace yii2\frontend\tests\functional;

use yii2\common\models\Identity;
use yii2\common\tests\cest\SendForm;
use yii2\common\fixtures\UserFixture;
use yii2\frontend\tests\FunctionalTester;
use Codeception\Exception\ModuleException;
use yii2\common\components\forms\BaseWebForm;
use yii2\frontend\controllers\AuthController;
use yii2\frontend\models\forms\ResendVerificationEmailForm;

/**
 * < Frontend > `ResendVerificationEmailCest`
 *
 * @package yii2\frontend\tests\functional
 *
 * @property FunctionalTester $I
 * @property ResendVerificationEmailForm $form
 *
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
class ResendVerificationEmailCest extends SendForm
{
    /** @var BaseWebForm */
    protected const BASE_FORM_CLASS = ResendVerificationEmailForm::class;


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
     * @see AuthController::actionResendVerificationEmail()
     *
     * @tag #frontend #tests #functional #ResendVerificationEmailCest #_before
     */
    public function _before(FunctionalTester $I): void
    {
        parent::_before($I);

        $route = AuthController::getEndpoint(AuthController::ACTION_RESEND_VERIFICATION_EMAIL); // 'auth/resend-verification-email'

        $I->amOnRoute($route);
    }

    /**
     * @param string $email
     *
     * @return array
     */
    protected function formParams( string $email): array
    {
        return [
            "$this->formName[".$this->form::ATTR_EMAIL."]" => $email
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
        $I->see($this->form::TITLE, 'h1');
        $I->see($this->form::HINT, 'p');
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
        $I->seeValidationError(ResendVerificationEmailForm::RULE_EXIST_MESSAGE);
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
        $I->seeValidationError(ResendVerificationEmailForm::RULE_EXIST_MESSAGE);
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
        $I->seeRecord(Identity::class, [
            'email' => 'test@mail.com',
            'username' => 'test.test',
            'status' => Identity::STATUS_INACTIVE
        ]);
        $I->see(ResendVerificationEmailForm::MESSAGE_SUCCESS);
    }
}
