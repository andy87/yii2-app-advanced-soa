<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\common\models\forms\LoginForm;
use app\frontend\components\models\BaseSendForm;
use app\frontend\models\forms\SignupForm;
use app\frontend\tests\cest\SendForm;
use app\frontend\tests\FunctionalTester;
use Codeception\Exception\ModuleException;
use app\frontend\controllers\AuthController;
use yii\base\Model;

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
    /** @var BaseSendForm */
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

        $roure = AuthController::ENDPOINT . '/' . AuthController::ACTION_SIGNUP;

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
        $I->see('Signup', 'h1');
        $I->see('Please fill out the following fields to signup:');
        $I->submitForm($this->formId, []);
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');

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
        $I->submitForm(
            $this->formId, [
            'SignupForm[username]'  => 'tester',
            'SignupForm[email]'     => 'ttttt',
            'SignupForm[password]'  => 'tester_password',
        ]
        );
        $I->dontSee('Username cannot be blank.', '.invalid-feedback');
        $I->dontSee('Password cannot be blank.', '.invalid-feedback');
        $I->see('Email is not a valid email address.', '.invalid-feedback');
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
     *
     */
    public function signupSuccessfully(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'tester',
            'SignupForm[email]' => 'tester.email@example.com',
            'SignupForm[password]' => 'tester_password',
        ]);

        $I->seeRecord('app\common\models\Identity', [
            'username' => 'tester',
            'email' => 'tester.email@example.com',
            'status' => \app\common\models\Identity::STATUS_INACTIVE
        ]);

        $I->seeEmailIsSent();
        $I->see('Thank you for registration. Please check your inbox for verification email.');
    }
}
