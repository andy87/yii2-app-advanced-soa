<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use andy87\lazy_load\yii2\LazyLoadTrait;
use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;
use Yii;
use yii\base\InvalidConfigException;
use yii\mail\MessageInterface;
use yii2\common\fixtures\UserFixture;
use yii2\frontend\{models\forms\ResendVerificationEmailForm, services\controllers\AuthService, tests\UnitTester};

/**
 * < Frontend > `ResendVerificationEmailFormTest`
 *
 * @property-read AuthService $authService
 *
 * @package yii2\frontend\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ResendVerificationEmailFormTest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ResendVerificationEmailFormTest.php
 *
 * @tags #frontend #tests #unit #models #ResendVerificationEmailFormTest
 */
class ResendVerificationEmailFormTest extends Unit
{
    use LazyLoadTrait;

    /** @var UnitTester */
    protected UnitTester $tester;


    public array $lazyLoadConfig = [
        'authService' => AuthService::class
    ];



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
     * @param array $attributes
     *
     * @return ResendVerificationEmailForm
     */
    private function getResendVerificationEmailForm( array $attributes = [] ): ResendVerificationEmailForm
    {
        $resendVerificationEmailForm = new ResendVerificationEmailForm();
        $resendVerificationEmailForm->attributes = $attributes;

        return $resendVerificationEmailForm;
    }

    /**
     * Wrong email address
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ResendVerificationEmailFormTest:testWrongEmailAddress
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ResendVerificationEmailFormTest.php#L28
     *
     * @return void
     *
     * @tag #frontend #tests #resend #wrong #email
     */
    public function testWrongEmailAddress(): void
    {
        $resendVerificationEmailForm = $this->getResendVerificationEmailForm([
            ResendVerificationEmailForm::ATTR_EMAIL => 'aaa@bbb.cc'
        ]);

        $this->assertFalse($resendVerificationEmailForm->validate());
        $this->assertTrue($resendVerificationEmailForm->hasErrors());
        $this->assertSame($resendVerificationEmailForm::RULE_EXIST_MESSAGE, $resendVerificationEmailForm->getFirstError('email'));
    }

    /**
     * Empty email address
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ResendVerificationEmailFormTest:testEmptyEmailAddress
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ResendVerificationEmailFormTest.php#L40
     *
     * @return void
     *
     * @tag #frontend #tests #resend #empty #email
     */
    public function testEmptyEmailAddress(): void
    {
        $resendVerificationEmailForm = $this->getResendVerificationEmailForm([
            ResendVerificationEmailForm::ATTR_EMAIL => ''
        ]);

        $this->assertFalse($resendVerificationEmailForm->validate());
        $this->assertTrue($resendVerificationEmailForm->hasErrors());
        $this->assertSame('Email cannot be blank.', $resendVerificationEmailForm->getFirstError('email'));
    }

    /**
     * Resend to active user
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ResendVerificationEmailFormTest:testResendToActiveUser
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ResendVerificationEmailFormTest.php#L52
     *
     * @return void
     *
     * @tag #frontend #tests #resend #active #user
     */
    public function testResendToActiveUser(): void
    {
        $resendVerificationEmailForm = $this->getResendVerificationEmailForm([
            ResendVerificationEmailForm::ATTR_EMAIL => 'test2@mail.com'
        ]);

        $this->assertFalse($resendVerificationEmailForm->validate());
        $this->assertTrue($resendVerificationEmailForm->hasErrors());
        $this->assertSame($resendVerificationEmailForm::RULE_EXIST_MESSAGE, $resendVerificationEmailForm->getFirstError('email'));
    }

    /**
     * Successfully resend
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ResendVerificationEmailFormTest:testSuccessfullyResend
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ResendVerificationEmailFormTest.php#L64
     *
     * @return void
     *
     * @throws InvalidConfigException|ModuleException
     *
     * @tag #frontend #tests #resend #inactive #user
     */
    public function testSuccessfullyResend(): void
    {
        $resendVerificationEmailForm = $this->getResendVerificationEmailForm([
            ResendVerificationEmailForm::ATTR_EMAIL => 'test@mail.com'
        ]);

        $this->assertTrue($resendVerificationEmailForm->validate());
        $this->assertFalse($resendVerificationEmailForm->hasErrors());

        $sendResult = $this->authService->handlerResendVerificationEmail($resendVerificationEmailForm);

        $this->assertTrue($sendResult);

        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        $this->assertInstanceOf(MessageInterface::class, $mail);
        $this->assertArrayHasKey('test@mail.com', $mail->getTo());
        $this->assertArrayHasKey(Yii::$app->params['supportEmail'], $mail->getFrom());
        $this->assertSame($resendVerificationEmailForm->generateMailSubject(), $mail->getSubject());
        $this->assertStringContainsString('4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330', $mail->toString());
    }
}
