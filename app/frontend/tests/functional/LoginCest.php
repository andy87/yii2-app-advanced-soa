<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\frontend\tests\FunctionalTester;
use app\common\fixtures\UserFixture;

/**
 * < Frontend > `LoginCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
 *
 * Fix not used:
 * - @see LoginCest::checkEmpty()
 * - @see LoginCest::checkWrongPassword()
 * - @see LoginCest::checkInactiveAccount()
 * - @see LoginCest::checkValidLogin()
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest
 *
 * @tag #frontend #tests #functional #LoginCest
 */
class LoginCest
{
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
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    /**
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #LoginCest #checkEmpty
     */
    public function _before(FunctionalTester $I): void
    {
        $I->amOnRoute('site/login');
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return array
     */
    protected function formParams( string $login, string $password): array
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest:checkEmpty
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #LoginCest #checkEmpty
     */
    public function checkEmpty(FunctionalTester $I): void
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest:checkWrongPassword
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #LoginCest #checkWrongPassword
     */
    public function checkWrongPassword(FunctionalTester $I): void
    {
        $I->submitForm('#login-form', $this->formParams('admin', 'wrong'));
        $I->seeValidationError('Incorrect username or password.');
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest:checkInactiveAccount
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #LoginCest #checkInactiveAccount
     */
    public function checkInactiveAccount(FunctionalTester $I): void
    {
        $I->submitForm('#login-form', $this->formParams('test.test', 'Test1234'));
        $I->seeValidationError('Incorrect username or password');
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest:checkValidLogin
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #LoginCest #checkValidLogin
     */
    public function checkValidLogin(FunctionalTester $I): void
    {
        $I->submitForm('#login-form', $this->formParams('erau', 'password_0'));
        $I->see('Logout (erau)', 'form button[type=submit]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
