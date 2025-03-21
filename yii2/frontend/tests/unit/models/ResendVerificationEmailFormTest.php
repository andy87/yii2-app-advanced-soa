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

        verify($resendVerificationEmailForm->validate())->false();
        verify($resendVerificationEmailForm->hasErrors())->true();
        verify($resendVerificationEmailForm->getFirstError('email'))->equals($resendVerificationEmailForm::RULE_EXIST_MESSAGE);
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

        verify($resendVerificationEmailForm->validate())->false();
        verify($resendVerificationEmailForm->hasErrors())->true();
        verify($resendVerificationEmailForm->getFirstError('email'))->equals('Email cannot be blank.');
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

        verify($resendVerificationEmailForm->validate())->false();
        verify($resendVerificationEmailForm->hasErrors())->true();
        verify($resendVerificationEmailForm->getFirstError('email'))->equals($resendVerificationEmailForm::RULE_EXIST_MESSAGE);
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

        verify($resendVerificationEmailForm->validate())->true();
        verify($resendVerificationEmailForm->hasErrors())->false();

        $sendResult = $this->authService->handlerResendVerificationEmail($resendVerificationEmailForm);

        verify($sendResult)->true();

        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        verify($mail)->instanceOf(MessageInterface::class);
        verify($mail->getTo())->arrayHasKey('test@mail.com');
        verify($mail->getFrom())->arrayHasKey(Yii::$app->params['supportEmail']);
        verify($mail->getSubject())->equals($resendVerificationEmailForm->generateMailSubject());
        verify($mail->toString())->stringContainsString('4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330');
    }
}
