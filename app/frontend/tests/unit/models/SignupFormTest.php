<?php

namespace app\frontend\tests\unit\models;

use app\common\fixtures\UserFixture;
use app\frontend\models\forms\SignupForm;
use function frontend\tests\unit\models\codecept_data_dir;
use function frontend\tests\unit\models\verify;

class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \app\frontend\tests\_support\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
        ]);

        $user = $model->signup();
        verify($user)->notEmpty();

        /** @var \app\common\models\User $user */
        $user = $this->tester->grabRecord('app\common\models\User', [
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'status' => \app\common\models\User::STATUS_INACTIVE
        ]);

        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        verify($mail)->instanceOf('yii\mail\MessageInterface');
        verify($mail->getTo())->arrayHasKey('some_email@example.com');
        verify($mail->getFrom())->arrayHasKey(\Yii::$app->params['supportEmail']);
        verify($mail->getSubject())->equals('Account registration at ' . \Yii::$app->name);
        verify($mail->toString())->stringContainsString($user->verification_token);
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'troy.becker',
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ]);

        verify($model->signup())->empty();
        verify($model->getErrors('username'))->notEmpty();
        verify($model->getErrors('email'))->notEmpty();

        verify($model->getFirstError('username'))
            ->equals('This username has already been taken.');
        verify($model->getFirstError('email'))
            ->equals('This email address has already been taken.');
    }
}
