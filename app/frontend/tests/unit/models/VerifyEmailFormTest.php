<?php declare(strict_types=1);

namespace app\frontend\tests\unit\models;

use app\common\fixtures\UserFixture;
use app\frontend\models\forms\VerifyEmailForm;
use function frontend\tests\unit\models\codecept_data_dir;
use function frontend\tests\unit\models\verify;

class VerifyEmailFormTest extends \Codeception\Test\Unit
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

    public function testVerifyWrongToken()
    {
        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new VerifyEmailForm('');
        });

        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new VerifyEmailForm('notexistingtoken_1391882543');
        });
    }

    public function testAlreadyActivatedToken()
    {
        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new VerifyEmailForm('already_used_token_1548675330');
        });
    }

    public function testVerifyCorrectToken()
    {
        $model = new VerifyEmailForm('4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330');
        $user = $model->verifyEmail();
        verify($user)->instanceOf('app\common\models\Identity');

        verify($user->username)->equals('test.test');
        verify($user->email)->equals('test@mail.com');
        verify($user->status)->equals(\app\common\models\Identity::STATUS_ACTIVE);
        verify($user->validatePassword('Test1234'))->true();
    }
}
