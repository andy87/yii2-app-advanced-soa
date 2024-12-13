<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;


use Yii;
use Codeception\Test\Unit;
use yii\mail\MessageInterface;
use yii\db\Exception as YiiDbException;
use Codeception\Exception\ModuleException;
use yii2\common\{fixtures\UserFixture, models\Identity, services\IdentityService};
use yii\base\{Exception as YiiBaseException, InvalidConfigException};
use yii2\frontend\{controllers\AuthController,
    models\forms\PasswordResetRequestForm,
    services\AuthService,
    tests\UnitTester};

/**
 * < Frontend > `PasswordResetRequestFormTest`
 *
 * @package yii2\frontend\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/PasswordResetRequestFormTest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/PasswordResetRequestFormTest.php
 *
 * @see AuthController::actionRequestPasswordReset()
 *
 * @tags #frontend #tests #unit #models #PasswordResetRequestForm
 */
class PasswordResetRequestFormTest extends Unit
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
            ]
        ]);
    }

    /**
     * Send message with wrong email address
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/PasswordResetRequestFormTest:testSendMessageWithWrongEmailAddress
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/VerifyEmailFormTest.php
     *
     * @return void
     *
     * @throws InvalidConfigException|YiiBaseException
     *
     * @tag #frontend #tests #reset #wrong #email
     */
    public function testSendMessageWithWrongEmailAddress(): void
    {
        $passwordResetRequestForm= new PasswordResetRequestForm();
        $passwordResetRequestForm->email = 'not-existing-email@example.com';

        $sendResult = AuthService::getInstance()->handlerRequestPasswordResetResources($passwordResetRequestForm);

        verify($sendResult)->false();
    }

    /**
     * Not send emails to inactive user
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/PasswordResetRequestFormTest:testNotSendEmailsToInactiveUser
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/PasswordResetRequestFormTest.php#L35
     *
     * @return void
     *
     * @throws ModuleException|YiiDbException|YiiBaseException
     *
     * @tag #frontend #tests #reset #inactive #user
     *
     */
    public function testNotSendEmailsToInactiveUser()
    {
        $user = $this->tester->grabFixture('user', 1);

        $passwordResetRequestForm = new PasswordResetRequestForm();
        $passwordResetRequestForm->email = $user['email'];

        $sendResult = AuthService::getInstance()->handlerRequestPasswordResetResources($passwordResetRequestForm);

        verify($sendResult)->false();
    }

    /**
     * Send email successfully
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/PasswordResetRequestFormTest:testSendEmailSuccessfully
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/PasswordResetRequestFormTest.php#43
     *
     * @return void
     *
     * @throws ModuleException|YiiDbException|YiiBaseException
     *
     * @tag #frontend #tests #reset #correct
     *
     */
    public function testSendEmailSuccessfully(): void
    {
        $userFixture = $this->tester->grabFixture('user', 0);

        $passwordResetRequestForm = new PasswordResetRequestForm();
        $passwordResetRequestForm->email = $userFixture['email'];

        $identity = IdentityService::getInstance()->findIdentityByPasswordResetToken($userFixture['password_reset_token']);

        verify($identity)->instanceOf(Identity::class);

        $sendResult = AuthService::getInstance()->handlerRequestPasswordResetResources($passwordResetRequestForm);

        verify($sendResult)->notEmpty();

        $identity = $passwordResetRequestForm->getIdentity();

        verify($identity->password_reset_token)->notEmpty();

        $emailMessage = $this->tester->grabLastSentEmail();

        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey($passwordResetRequestForm->email);
        verify($emailMessage->getFrom())->arrayHasKey(Yii::$app->params['supportEmail']);
    }
}
