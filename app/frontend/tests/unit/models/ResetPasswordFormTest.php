<?php

namespace app\frontend\tests\unit\models;

use app\common\fixtures\UserFixture;
use app\frontend\models\ResetPasswordForm;
use function frontend\tests\unit\models\codecept_data_dir;
use function frontend\tests\unit\models\verify;

class ResetPasswordFormTest extends \Codeception\Test\Unit
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
            ],
        ]);
    }

    public function testResetWrongToken()
    {
        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new ResetPasswordForm('');
        });

        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new ResetPasswordForm('notexistingtoken_1391882543');
        });
    }

    public function testResetCorrectToken()
    {
        $user = $this->tester->grabFixture('user', 0);
        $form = new ResetPasswordForm($user['password_reset_token']);
        verify($form->resetPassword())->notEmpty();
    }

}
