<?php declare(strict_types=1);

namespace yii2\common\tests\unit\models;

use andy87\lazy_load\yii2\LazyLoadTrait;
use Yii;
use Codeception\Test\Unit;
use yii\base\InvalidConfigException;
use yii2\common\{components\Result,
    tests\UnitTester,
    services\AuthService,
    fixtures\UserFixture,
    models\forms\LoginForm};
use yii\symfonymailer\Message;

/**
 * < Common > `LoginFormTest`
 *
 *      Login form test
 *
 * @property-read AuthService $authService
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
    use LazyLoadTrait;

    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    private LoginForm $loginForm;

    public array $lazyLoadConfig = [
        'authService' => AuthService::class
    ];



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

        $this->assertFalse($this->authService->authLoginForm($this->loginForm));
        $this->assertTrue(Yii::$app->user->isGuest);
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

        $this->authService->authLoginForm($this->loginForm);

        $login = ( $this->loginForm->result === Result::OK );

        $this->assertFalse($login);
        $this->assertArrayHasKey('password', $this->loginForm->errors);
        $this->assertTrue(Yii::$app->user->isGuest);
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

        $this->assertTrue($this->authService->authLoginForm($this->loginForm));
        $this->assertArrayNotHasKey('password', $this->loginForm->errors);
        $this->assertFalse(Yii::$app->user->isGuest);
    }
}
