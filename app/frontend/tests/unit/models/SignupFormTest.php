<?php declare(strict_types=1);

namespace app\frontend\tests\unit\models;

use Exception;
use Codeception\Test\Unit;
use yii\mail\MessageInterface;
use yii\base\InvalidConfigException;
use Codeception\Exception\ModuleException;
use app\frontend\{ models\forms\SignupForm, services\AuthService, tests\UnitTester };
use app\common\{fixtures\UserFixture, models\Identity, models\sources\User, services\IdentityService};

/**
 * < Frontend > `SignupFormTest`
 *
 * @package app\frontend\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/SignupFormTest
 *
 * @tags #frontend #tests #unit #models #SignupForm
 */
class SignupFormTest extends Unit
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
     * @param array $attributes
     *
     * @return User
     *
     * @tag #frontend #tests #get #user
     */
    private function getUser(array $attributes): User
    {
        $user = new User;

        verify($attributes)->arrayHasKey(User::ATTR_USERNAME);
        verify($attributes)->arrayHasKey(User::ATTR_EMAIL);
        verify($attributes)->arrayHasKey(User::ATTR_PASSWORD);

        $user->setAttributes($attributes);
        $user->password = $attributes[User::ATTR_PASSWORD];

        verify($user->attributes)->arrayHasKey(User::ATTR_USERNAME);
        verify($user->attributes)->arrayHasKey(User::ATTR_EMAIL);
        verify((array) $user)->arrayHasKey(User::ATTR_PASSWORD);

        return $user;
    }

    /**
     * Correct signup
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/SignupFormTest:testCorrectSignup
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

        AuthService::getInstance()->handlerSignupForm($signupForm);

        verify($signupForm->identity)->notEmpty();

        /** @var Identity $identity */
        $identity = $this->tester->grabRecord(Identity::class, [
            Identity::ATTR_USERNAME => $user->username,
            Identity::ATTR_EMAIL => $user->email,
            Identity::ATTR_STATUS => Identity::STATUS_INACTIVE
        ]);

        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        verify($mail)->instanceOf(MessageInterface::class);
        verify($mail->getTo())->arrayHasKey('some_email@example.com');
        verify($mail->getFrom())->arrayHasKey(\Yii::$app->params['supportEmail']);
        verify($mail->getSubject())->equals($signupForm->getSubject());
        verify($mail->toString())->stringContainsString($identity->verification_token);
    }

    /**
     * Not correct signup
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/SignupFormTest:testNotCorrectSignup
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

        $identity = IdentityService::getInstance()->signUp($signupForm);

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