<?php declare(strict_types=1);

namespace backend\tests\functional;

use backend\controllers\AuthController;
use backend\tests\FunctionalTester;
use common\components\enums\Endpoints;
use common\components\Layout;
use common\models\forms\LoginForm;
use commonfixtures\UserFixture;
use commontests\cest\SendForm;

/**
 * < Backend > `LoginCest`
 *
 * @package yii2\backend\tests\functional
 *
 * @cli ./vendor/bin/codecept run yii2/backend/tests/functional/LoginCest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/backend/tests/functional/LoginCest.php
 *
 * @property LoginForm $form
 *
 * Fix not used:
 * - @see LoginCest::loginUser()
 *
 * @tag #tests #functional #LoginCest
 */
class LoginCest extends SendForm
{
    protected const BASE_FORM_CLASS = LoginForm::class;

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
     * @cli ./vendor/bin/codecept run yii2/backend/tests/functional/LoginCest:testLoginUser
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/backend/tests/functional/LoginCest.php#L33
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see AuthController::actionLogin()
     *
     * @tag #backend #functional #login #user
     */
    public function loginUser(FunctionalTester $I): void
    {
        $route = AuthController::getEndpoint(Endpoints::LOGIN);

        $I->amOnRoute($route);

        $dataField = [
            $this->form::ATTR_USERNAME => 'erau',
            $this->form::ATTR_PASSWORD => 'password_0',
        ];

        foreach ($dataField as $attr => $value) {
            $I->fillField($this->formName. '['.$attr.']', $value);
        }

        $I->click('login-button');

        $I->see(Layout::BUTTON_TEXT_LOGOUT . ' (erau)', 'form button[type=submit]');
        $I->dontSeeLink(LoginForm::BUTTON_LOGIN_TEXT);
        $I->dontSeeLink(Layout::BUTTON_TEXT_LOGIN);
    }
}
