<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use Codeception\Test\Unit;
use yii2\common\fixtures\UserFixture;
use Codeception\Exception\ModuleException;
use yii2\frontend\{models\forms\ResetPasswordForm, services\AuthService, tests\UnitTester};
use yii\base\{Exception, InvalidArgumentException, InvalidConfigException};

/**
 * < Frontend > `ResetPasswordFormTest`
 *
 * @package yii2\frontend\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ResetPasswordFormTest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ResetPasswordFormTest.php
 *
 * @see AuthController::actionResetPassword()
 *
 * @tags #frontend #tests #unit #models #ResetPasswordForm
 */
class ResetPasswordFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;



    /**
     * @return void
     *
     * @tag #frontend #tests #fixtures #user
     */
    public function _before(): void
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }

    /**
     * Reset wrong token
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ResetPasswordFormTest:testResetWrongToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ResetPasswordFormTest.php#L26
     *
     * @return void
     *
     * @tag #frontend #tests #reset #wrong #token
     */
    public function testResetWrongToken()
    {
        $this->tester->expectThrowable(InvalidArgumentException::class, function() {
            new ResetPasswordForm('');
        });

        $this->tester->expectThrowable(InvalidArgumentException::class, function() {
            new ResetPasswordForm('notexistingtoken_1391882543');
        });
    }

    /**
     * Reset correct token
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ResetPasswordFormTest:testResetCorrectToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ResetPasswordFormTest.php#L37
     *
     * @return void
     *
     * @throws ModuleException|InvalidConfigException|Exception
     *
     * @tag #frontend #tests #reset #correct #token
     */
    public function testResetCorrectToken(): void
    {
        $user = $this->tester->grabFixture('user', 0);

        $resetPasswordForm = new ResetPasswordForm($user['password_reset_token']);

        $resultResetPassword = AuthService::getInstance()->resetPassword($resetPasswordForm);

        verify($resultResetPassword)->notEmpty();
    }

}
