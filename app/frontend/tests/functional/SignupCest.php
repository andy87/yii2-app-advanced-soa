<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\frontend\tests\FunctionalTester;

/**
 * < Frontend > `SignupCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
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
class SignupCest
{
    /** @var string $formId */
    protected $formId = '#form-signup';


    /**
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #SignupCest #_before
     */
    public function _before(FunctionalTester $I): void
    {
        $I->amOnRoute('site/signup');
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/SignupCest:signupWithEmptyFields
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
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/SignupCest:signupWithWrongEmail
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
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/SignupCest:signupSuccessfully
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #SignupCest #signupSuccessfully
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
