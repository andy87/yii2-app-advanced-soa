<?php declare(strict_types=1);

namespace app\backend\tests\functional;

use app\backend\tests\FunctionalTester;
use app\common\fixtures\UserFixture;

/**
 * < Backend > `LoginCest`
 *
 *      Class LoginCest
 *
 * @package app\backend\tests\functional
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/functional/LoginCest
 *
 * @tag #backend #functional #login
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
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }
    
    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/LoginCest:testLoginUser
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #backend #functional #login #user
     */
    public function loginUser(FunctionalTester $I): void
    {
        $I->amOnRoute('/site/login');
        $I->fillField('Username', 'erau');
        $I->fillField('Password', 'password_0');
        $I->click('login-button');

        $I->see('Logout (erau)', 'form button[type=submit]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
