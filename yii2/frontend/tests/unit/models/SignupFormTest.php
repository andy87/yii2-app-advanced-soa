<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use andy87\lazy_load\yii2\LazyLoadTrait;
use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;
use Exception;
use yii\base\InvalidConfigException;
use yii\mail\MessageInterface;
use yii2\common\{fixtures\UserFixture, models\Identity, models\sources\User, services\IdentityService};
use yii2\frontend\{models\forms\SignupForm, services\controllers\AuthService, tests\UnitTester};

/**
 * < Frontend > `SignupFormTest`
 *
 * @property-read AuthService $authService
 * @property-read IdentityService $identityService
 *
 * @package yii2\frontend\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/SignupFormTest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/SignupFormTest.php
 *
 * @tags #frontend #tests #unit #models #SignupForm
 */
class SignupFormTest extends Unit
{
    use LazyLoadTrait;


    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    public array $lazyLoadConfig = [
        'authService'=> AuthService::class,
        'identityService'=> IdentityService::class
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
     * @return User
     *
     * @tag #frontend #tests #get #user
     */
    private function getUser(array $attributes): User
    {
        $user = new User;

        verify($attributes)->arrayHasKey($user::ATTR_USERNAME);
        verify($attributes)->arrayHasKey($user::ATTR_EMAIL);
        verify($attributes)->arrayHasKey($user::ATTR_PASSWORD);

        $user->setAttributes($attributes);
        $user->password = $attributes[$user::ATTR_PASSWORD];

        verify($user->attributes)->arrayHasKey($user::ATTR_USERNAME);
        verify($user->attributes)->arrayHasKey($user::ATTR_EMAIL);
        verify((array) $user)->arrayHasKey($user::ATTR_PASSWORD);

        return $user;
    }

    /**
     * Correct signup
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/SignupFormTest:testCorrectSignup
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/SignupFormTest.php#L26
     *
     * @return void
     *
     * @throws ModuleException|InvalidConfigException|Exception
     *
     * @tag #frontend #tests #signup #correct
     */
    public function testCorrectSignup(): void
    {
        $user = $this->getUser([
            User::ATTR_USERNAME => 'some_username',
            User::ATTR_EMAIL => 'some_email@example.com',
            User::ATTR_PASSWORD => 'some_password'
        ]);

        $signupForm = $this->constructSignupForm($user);

        $this->authService->handlerSignupForm($signupForm);

        verify($signupForm->identity)->notEmpty();

        /** @var Identity $identity */
        $identity = $this->tester->grabRecord(Identity::class, [
            $signupForm->identity::ATTR_USERNAME => $user->username,
            $signupForm->identity::ATTR_EMAIL => $user->email,
            $signupForm->identity::ATTR_STATUS => Identity::STATUS_INACTIVE
        ]);

        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        verify($mail)->instanceOf(MessageInterface::class);
        verify($mail->getTo())->arrayHasKey('some_email@example.com');
        verify($mail->getFrom())->arrayHasKey(\Yii::$app->params['supportEmail']);
        verify($mail->getSubject())->equals($signupForm->generateMailSubject());
        verify($mail->toString())->stringContainsString($identity->verification_token);
    }

    /**
     * Not correct signup
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/SignupFormTest:testNotCorrectSignup
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/SignupFormTest.php#L55
     *
     * @return void
     *
     * @throws InvalidConfigException|Exception
     *
     * @tag #frontend #tests #signup #not_correct
     *
     */
    public function testNotCorrectSignup(): void
    {
        $user = $this->getUser([
            User::ATTR_USERNAME => 'troy.becker',
            User::ATTR_EMAIL => 'nicolas.dianna@hotmail.com',
            User::ATTR_PASSWORD => 'some_password'
        ]);

        $signupForm = $this->constructSignupForm($user);

        $identity = $this->identityService->signUp($signupForm);

        verify($identity)->empty();
        verify($signupForm->getErrors('username'))->notEmpty();
        verify($signupForm->getErrors('email'))->notEmpty();

        verify($signupForm->getFirstError('username'))->equals(SignupForm::RULE_EXCEPTION_USERNAME_UNIQUE);
        verify($signupForm->getFirstError('email'))->equals(SignupForm::RULE_EXCEPTION_EMAIL_UNIQUE);
    }

    /**
     * @param User $user
     *
     * @return SignupForm
     *
     * @tag #frontend #tests #signup #construct
     */
    private function constructSignupForm( User $user ): SignupForm
    {
        return new SignupForm([
            SignupForm::ATTR_USERNAME => $user->username,
            SignupForm::ATTR_EMAIL => $user->email,
            SignupForm::ATTR_PASSWORD => $user->password
        ]);
    }
}