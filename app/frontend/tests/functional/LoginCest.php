<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\common\components\Action;
use app\common\fixtures\UserFixture;
use app\frontend\tests\cest\SendForm;
use app\common\models\forms\LoginForm;
use app\frontend\tests\FunctionalTester;
use app\frontend\controllers\AuthController;
use app\frontend\components\models\BaseWebForm;

/**
 * < Frontend > `LoginCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
 * @property LoginForm $form
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/LoginCest.php
 *
 * @tag #tests #functional #LoginCest
 */
class LoginCest extends SendForm
{
    /** @var BaseWebForm */
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
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    /**
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see AuthController::actionLogin()
     *
     * @tag #frontend #tests #functional #LoginCest #checkEmpty
     */
    public function _before(FunctionalTester $I): void
    {
        parent::_before($I);

        $route = AuthController::ENDPOINT . '/' . Action::LOGIN; // 'auth/login'

        $I->amOnRoute($route);
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
            "$this->formName[". $this->form::ATTR_USERNAME."]" => $login,
            "$this->formName[". $this->form::ATTR_PASSWORD."]" => $password,
        ];
    }

    /**
     * `Check empty`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest:checkEmpty
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/LoginCest.php#40
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #LoginCest #checkEmpty
     */
    public function checkEmpty(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, $this->formParams('', ''));

        $messages = [
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_USERNAME), $this->form::RULE_REQUIRED_TEMPLATE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_PASSWORD), $this->form::RULE_REQUIRED_TEMPLATE),
        ];

        foreach ($messages as $attribute => $message) {
            $I->seeValidationError($message);
        }
    }

    /**
     * Check wrong password
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest:checkWrongPassword
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/LoginCest.php#47
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #LoginCest #checkWrongPassword
     */
    public function checkWrongPassword(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, $this->formParams('admin', 'wrong'));
        $I->seeValidationError(LoginForm::RULE_MESSAGE_WRONG_USER_NAME_OR_PASSWORD);
    }

    /**
     * Check inactive account
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest:checkInactiveAccount
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/LoginCest.php#53
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #LoginCest #checkInactiveAccount
     */
    public function checkInactiveAccount(FunctionalTester $I): void
    {
        // [yii\base\InvalidArgumentException] Hash is invalid.
        $I->submitForm($this->formId, $this->formParams('test.test', 'Test1234'));
        $I->seeValidationError(LoginForm::RULE_MESSAGE_WRONG_USER_NAME_OR_PASSWORD);
    }

    /**
     * Check valid login
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/LoginCest:checkValidLogin
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/LoginCest.php#59
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #LoginCest #checkValidLogin
     */
    public function checkValidLogin(FunctionalTester $I): void
    {
        $I->submitForm($this->formId, $this->formParams('erau', 'password_0'));
        $I->see('Logout (erau)', 'form button[type=submit]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
