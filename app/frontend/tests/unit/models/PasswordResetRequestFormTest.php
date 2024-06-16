<?php declare(strict_types=1);

namespace app\frontend\tests\unit\models;


use Yii;
use Codeception\Test\Unit;
use yii\mail\MessageInterface;
use yii\db\Exception as YiiDbException;
use Codeception\Exception\ModuleException;
use app\common\{ fixtures\UserFixture, services\IdentityService };
use yii\base\{Exception as YiiBaseException, InvalidConfigException};
use app\frontend\{models\forms\PasswordResetRequestForm, services\AuthService, tests\UnitTester};

/**
 * < Frontend > `PasswordResetRequestFormTest`
 *
 * @package app\frontend\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/PasswordResetRequestFormTest
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
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/PasswordResetRequestFormTest:testSendMessageWithWrongEmailAddress
     *
     * @return void
     *
     * @throws InvalidConfigException|YiiDbException|YiiBaseException
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
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/PasswordResetRequestFormTest:testNotSendEmailsToInactiveUser
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
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/PasswordResetRequestFormTest:testSendEmailSuccessfully
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

        $user = IdentityService::getInstance()
            ->findIdentityByPasswordResetToken($userFixture['password_reset_token']);

        $sendResult = AuthService::getInstance()
            ->handlerRequestPasswordResetResources($passwordResetRequestForm);

        verify($sendResult)->notEmpty();
        verify($user->password_reset_token)->notEmpty();

        $emailMessage = $this->tester->grabLastSentEmail();
        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey($passwordResetRequestForm->email);
        verify($emailMessage->getFrom())->arrayHasKey(Yii::$app->params['supportEmail']);
    }
}
