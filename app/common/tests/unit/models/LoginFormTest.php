<?php declare(strict_types=1);

namespace app\common\tests\unit\models;

use app\common\fixtures\UserFixture;
use app\common\models\forms\LoginForm;
use app\common\tests\_support\UnitTester;
use Codeception\Test\Unit;
use Yii;
use function common\tests\unit\models\codecept_data_dir;
use function common\tests\unit\models\verify;

/**
 * < Common > `LoginFormTest`
 *
 *      Login form test
 *
 * @package app\common\tests\unit\models
 *
 * @tag #common #tests #unit #models #LoginForm
 */
class LoginFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;


    /**
     * @return array
     *
     * @tag #common #tests #unit #LoginForm #fixtures
     */
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    /**
     * @return void
     *
     * @tag #common #tests #unit #LoginForm #noUser
     */
    public function testLoginNoUser(): void
    {
        $loginForm = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        verify($loginForm->login())->false();
        verify(Yii::$app->user->isGuest)->true();
    }

    /**
     * @return void
     *
     * @tag #common #tests #unit #LoginForm #wrongPassword
     */
    public function testLoginWrongPassword(): void
    {
        $loginForm = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'wrong_password',
        ]);

        verify($loginForm->login())->false();
        verify( $loginForm->errors)->arrayHasKey('password');
        verify(Yii::$app->user->isGuest)->true();
    }

    /**
     * @return void
     *
     * @tag #common #tests #unit #LoginForm #correct
     */
    public function testLoginCorrect(): void
    {
        $loginForm = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]);

        verify($loginForm->login())->true();
        verify($loginForm->errors)->arrayHasNotKey('password');
        verify(Yii::$app->user->isGuest)->false();
    }
}
