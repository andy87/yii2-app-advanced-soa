<?php declare(strict_types=1);

namespace yii2\common\tests\unit\models;

use Yii;
use Codeception\Test\Unit;
use yii\base\InvalidConfigException;
use yii2\common\{tests\UnitTester, services\AuthService, fixtures\UserFixture, models\forms\LoginForm};
use yii\symfonymailer\Message;

/**
 * < Common > `LoginFormTest`
 *
 *      Login form test
 *
 * @package yii2\common\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run yii2/common/tests/unit/models/LoginFormTest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/common/tests/unit/models/LoginFormTest.php
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
     * @return void
     */
    public function setUp(): void
    {
        $this->loginForm = new LoginForm();
    }

    /**
     * @return array
     *
     * @tag #common #tests #unit #LoginForm #fixtures
     */
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    /**
     * @cli ./vendor/bin/codecept run yii2/common/tests/unit/models/LoginFormTest:testLoginNoUser
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/common/tests/unit/models/LoginFormTest.php#L33
     *
     * @return void
     *
     * @throws InvalidConfigException
     *
     * @tag #common #tests #unit #LoginForm #noUser
     */
    public function testLoginNoUser(): void
    {
        $this->loginForm->username = 'not_existing_username';
        $this->loginForm->password = 'not_existing_password';

        verify(AuthService::getInstance()->handlerLoginForm($this->loginForm))->false();
        verify(Yii::$app->user->isGuest)->true();
    }

    /**
     * @cli ./vendor/bin/codecept run yii2/common/tests/unit/models/LoginFormTest:testLoginWrongPassword
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/common/tests/unit/models/LoginFormTest.php#L44
     *
     * @return void
     *
     * @throws InvalidConfigException
     *
     * @tag #common #tests #unit #LoginForm #wrongPassword
     */
    public function testLoginWrongPassword(): void
    {
        $this->loginForm->username = 'bayer.hudson';
        $this->loginForm->password = 'wrong_password';

        $login = AuthService::getInstance()->handlerLoginForm($this->loginForm);

        verify($login)->false();
        verify( $this->loginForm->errors)->arrayHasKey('password');
        verify(Yii::$app->user->isGuest)->true();
    }

    /**
     * @cli ./vendor/bin/codecept run yii2/common/tests/unit/models/LoginFormTest:testLoginCorrect
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/common/tests/unit/models/LoginFormTest.php#L56
     *
     * @return void
     *
     * @throws InvalidConfigException
     *
     * @tag #common #tests #unit #LoginForm #correct
     */
    public function testLoginCorrect(): void
    {
        $this->loginForm->username = 'bayer.hudson';
        $this->loginForm->password = 'password_0';

        verify(AuthService::getInstance()->handlerLoginForm($this->loginForm))->true();
        verify($this->loginForm->errors)->arrayHasNotKey('password');
        verify(Yii::$app->user->isGuest)->false();
    }
}