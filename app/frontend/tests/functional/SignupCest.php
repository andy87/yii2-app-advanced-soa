<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\common\models\Identity;
use app\common\tests\cest\SendForm;
use app\frontend\tests\FunctionalTester;
use app\frontend\models\forms\SignupForm;
use Codeception\Exception\ModuleException;
use app\frontend\controllers\AuthController;
use app\common\components\forms\BaseWebForm;

/**
 * < Frontend > `SignupCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
 * @property SignupForm $form
 *
 * Fix not used:
 * - @see SignupCest::signupWithEmptyFields()
 * - @see SignupCest::signupWithWrongEmail()
 * - @see SignupCest::signupSuccessfully()
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/SignupCest
 *
 * @tag #frontend #tests #functional #SignupCest
 */
class SignupCest extends SendForm
{
    /** @var BaseWebForm */
    protected const BASE_FORM_CLASS = SignupForm::class;

    /**
     * @endpoint auth/signup
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see AuthController::actionSignup()
     *
     * @tag #frontend #tests #functional #SignupCest #_before
     */
    public function _before(FunctionalTester $I): void
    {
        parent::_before($I);

        $roure = AuthController::getEndpoint(AuthController::ACTION_SIGNUP);

        $I->amOnRoute( $roure );
    }

    /**
     * Signup with empty fields
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/SignupCest:signupWithEmptyFields
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/SignupCest.php#L17
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #SignupCest #signupWithEmptyFields
     */
    public function signupWithEmptyFields(FunctionalTester $I): void
    {
        $I->see( $this->form::TITLE, 'h1');
        $I->see($this->form::HINT, 'p');

        $I->submitForm($this->formId, []);

        $messages = [
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_USERNAME), $this->form::RULE_REQUIRED_MESSAGE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_EMAIL), $this->form::RULE_REQUIRED_MESSAGE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_PASSWORD), $this->form::RULE_REQUIRED_MESSAGE),
        ];

        foreach ($messages as $attribute => $message) {
            $I->seeValidationError($message);
        }
    }

    /**
     * Signup with wrong email
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/SignupCest:signupWithWrongEmail
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/SignupCest.php#L28
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #SignupCest #signupWithWrongEmail
     */
    public function signupWithWrongEmail(FunctionalTester $I): void
    {
        $I->submitForm( $this->formId, [
            $this->formName. '['.$this->form::ATTR_USERNAME.']' => 'tester',
            $this->formName. '['.$this->form::ATTR_EMAIL.']' => 'ttttt',
            $this->formName. '['.$this->form::ATTR_PASSWORD.']' => 'tester_password',
        ]);

        $messages = [
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_USERNAME), $this->form::RULE_REQUIRED_MESSAGE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_PASSWORD), $this->form::RULE_REQUIRED_MESSAGE),
        ];

        foreach ($messages as $message) {
            $I->dontSee($message, '.invalid-feedback');
        }

        $I->see( $this->form::RULE_MESSAGE_WRONG_EMAIL, '.invalid-feedback');
    }

    /**
     * Signup successfully
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/SignupCest:signupSuccessfully
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/SignupCest.php#L42
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @throws ModuleException
     *
     * @tag #frontend #tests #functional #SignupCest #signupSuccessfully
     */
    public function signupSuccessfully(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, [
            $this->formName. '['.$this->form::ATTR_USERNAME.']' => 'tester',
            $this->formName. '['.$this->form::ATTR_EMAIL.']' => 'tester.email@example.com',
            $this->formName. '['.$this->form::ATTR_PASSWORD.']' => 'tester_password',
        ]);

        $I->seeRecord(Identity::class, [
            Identity::ATTR_USERNAME => 'tester',
            Identity::ATTR_EMAIL => 'tester.email@example.com',
            Identity::ATTR_STATUS => Identity::STATUS_INACTIVE
        ]);

        $I->seeEmailIsSent();
        $I->see($this->form::MESSAGE_SUCCESS);
    }
}
