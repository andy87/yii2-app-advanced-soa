<?php declare(strict_types=1);

namespace app\backend\tests\functional;

use app\common\fixtures\UserFixture;
use app\backend\tests\FunctionalTester;
use app\backend\controllers\AuthController;

/**
 * < Backend > `LoginCest`
 *
 * @package app\backend\tests\functional
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/functional/LoginCest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/backend/tests/functional/LoginCest.php
 *
 * @tag #tests #functional #LoginCest
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
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/backend/tests/functional/LoginCest.php#L33
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #backend #functional #login #user
     */
    public function loginUser(FunctionalTester $I): void
    {
        /** @see AuthController::actionLogin() */
        $I->amOnRoute('/auth/login');
        $I->fillField('Username', 'erau');
        $I->fillField('Password', 'password_0');
        $I->click('login-button');

        $I->see('Logout (erau)', 'form button[type=submit]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
