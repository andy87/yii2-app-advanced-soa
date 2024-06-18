<?php declare(strict_types=1);

namespace app\frontend\tests\unit\models;

use yii\db\Exception;
use Codeception\Test\Unit;
use app\frontend\tests\UnitTester;
use app\common\{ fixtures\UserFixture, models\Identity };
use yii\base\{ InvalidArgumentException, InvalidConfigException };
use app\frontend\{ models\forms\VerifyEmailSendForm, services\AuthService };

/**
 * < Frontend > `VerifyEmailFormTest`
 *
 * @package app\frontend\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/VerifyEmailFormTest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/VerifyEmailFormTest.php
 *
 * @tags #frontend #tests #unit #models #VerifyEmailForm
 */
class VerifyEmailFormTest extends Unit
{
    /** @var UnitTester */
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
     * Verify wrong token
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/VerifyEmailFormTest:testWrongToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/VerifyEmailFormTest.php#L26
     *
     * @return void
     *
     * @tag #frontend #tests #verify #wrong #token
     */
    public function testVerifyWrongToken(): void
    {
        $this->tester->expectThrowable(InvalidArgumentException::class, function() {
            new VerifyEmailSendForm('');
        });

        $this->tester->expectThrowable(InvalidArgumentException::class, function() {
            new VerifyEmailSendForm('notexistingtoken_1391882543');
        });
    }

    /**
     * Already activated token
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/VerifyEmailFormTest:testAlreadyActivatedToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/VerifyEmailFormTest.php#L37
     *
     * @return void
     *
     * @tag #frontend #tests #verify #already #activated #token
     */
    public function testAlreadyActivatedToken(): void
    {
        $this->tester->expectThrowable(InvalidArgumentException::class, function() {
            new VerifyEmailSendForm('already_used_token_1548675330');
        });
    }

    /**
     * Verify correct token
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/VerifyEmailFormTest:testVerifyCorrectToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/VerifyEmailFormTest.php#L44
     *
     * @return void
     *
     * @throws InvalidConfigException|Exception
     *
     * @tag #frontend #tests #verify #correct #token
     */
    public function testVerifyCorrectToken(): void
    {
        $verifyEmailForm = new VerifyEmailSendForm('4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330');

        AuthService::getInstance()->handl1erAuthVerifyEmailResources($verifyEmailForm);

        $identity = $verifyEmailForm->getIdentity();

        verify($identity)->instanceOf(Identity::class);

        verify($identity->username)->equals('test.test');
        verify($identity->email)->equals('test@mail.com');
        verify($identity->status)->equals(Identity::STATUS_ACTIVE);
        verify($identity->validatePassword('Test1234'))->true();
    }
}
