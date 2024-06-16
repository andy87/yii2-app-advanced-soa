<?php declare(strict_types=1);

namespace app\common\tests\unit\models;

use Yii;
use Codeception\Test\Unit;
use yii\base\InvalidConfigException;
use app\common\{tests\UnitTester, services\AuthService, fixtures\UserFixture, models\forms\LoginForm};

/**
 * < Common > `LoginFormTest`
 *
 *      Login form test
 *
 * @package app\common\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/LoginFormTest
 *
 * @tag #common #tests #unit #models #LoginForm
 */
class LoginFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    private LoginForm $loginForm;

    /**
     * @return array
     *
     * @tag #common #tests #unit #LoginForm #fixtures
     */
    public function _fixtures(): array
    {
        $this->loginForm = new LoginForm();

        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    /**
     * @cli ./vendor/bin/codecept run app/common/tests/unit/models/LoginFormTest:testLoginNoUser
     *
     * @return void
     *
     * @throws InvalidConfigException
     *
     * @tag #common #tests #unit #LoginForm #noUser
     *
     */
    public function testLoginNoUser(): void
    {
        $this->loginForm->setAttributes([
            LoginForm::ATTR_USERNAME => 'not_existing_username',
            LoginForm::ATTR_PASSWORD => 'not_existing_password',
        ]);

        verify(AuthService::getInstance()->login($this->loginForm))->false();
        verify(Yii::$app->user->isGuest)->true();
    }

    /**
     * @cli ./vendor/bin/codecept run app/common/tests/unit/models/LoginFormTest:testLoginWrongPassword
     *
     * @return void
     *
     * @throws InvalidConfigException
     *
     * @tag #common #tests #unit #LoginForm #wrongPassword
     */
    public function testLoginWrongPassword(): void
    {
        $this->loginForm->setAttributes([
            LoginForm::ATTR_USERNAME => 'bayer.hudson',
            LoginForm::ATTR_PASSWORD => 'wrong_password',
        ]);

        $login = AuthService::getInstance()->login($this->loginForm);

        verify($login)->false();
        verify( $this->loginForm->errors)->arrayHasKey('password');
        verify(Yii::$app->user->isGuest)->true();
    }

    /**
     * @cli ./vendor/bin/codecept run app/common/tests/unit/models/LoginFormTest:testLoginCorrect
     *
     * @return void
     *
     * @throws InvalidConfigException
     *
     * @tag #common #tests #unit #LoginForm #correct
     */
    public function testLoginCorrect(): void
    {
        $this->loginForm->setAttributes([
            LoginForm::ATTR_USERNAME => 'bayer.hudson',
            LoginForm::ATTR_PASSWORD => 'password_0',
        ]);

        verify(AuthService::getInstance()->login($this->loginForm))->true();
        verify($this->loginForm->errors)->arrayHasNotKey('password');
        verify(Yii::$app->user->isGuest)->false();
    }
}
