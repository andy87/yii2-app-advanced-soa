<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use andy87\lazy_load\yii2\LazyLoadTrait;
use Codeception\Test\Unit;
use yii\base\{InvalidArgumentException, InvalidConfigException};
use yii\db\Exception;
use yii2\common\{fixtures\UserFixture, models\Identity};
use yii2\frontend\{models\forms\VerifyEmailForm, services\controllers\AuthService};
use yii2\frontend\tests\UnitTester;

/**
 * < Frontend > `VerifyEmailFormTest`
 *
 * @property-read AuthService $authService
 *
 * @package yii2\frontend\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/VerifyEmailFormTest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/VerifyEmailFormTest.php
 *
 * @tags #frontend #tests #unit #models #VerifyEmailForm
 */
class VerifyEmailFormTest extends Unit
{
    use LazyLoadTrait;

    /** @var UnitTester */
    protected UnitTester $tester;

    public array $lazyLoadConfig = [
        'authService'=> AuthService::class,
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
     * Verify wrong token
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/VerifyEmailFormTest:testWrongToken
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
            new VerifyEmailForm('');
        });

        $this->tester->expectThrowable(InvalidArgumentException::class, function() {
            new VerifyEmailForm('notexistingtoken_1391882543');
        });
    }

    /**
     * Already activated token
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/VerifyEmailFormTest:testAlreadyActivatedToken
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
            new VerifyEmailForm('already_used_token_1548675330');
        });
    }

    /**
     * Verify correct token
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/VerifyEmailFormTest:testVerifyCorrectToken
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
        $verifyEmailForm = new VerifyEmailForm('4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330');

        $this->authService->handlerAuthVerifyEmailResources($verifyEmailForm);

        $identity = $verifyEmailForm->getIdentity();

        verify($identity)->instanceOf(Identity::class);

        verify($identity->username)->equals('test.test');
        verify($identity->email)->equals('test@mail.com');
        verify($identity->status)->equals(Identity::STATUS_ACTIVE);
        verify($identity->validatePassword('Test1234'))->true();
    }
}
