<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\common\fixtures\UserFixture;
use app\frontend\tests\FunctionalTester;

/**
 * < Frontend > `VerifyEmailCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
 *
 * Fix not used:
 * - @see VerifyEmailCest::checkEmptyToken()
 * - @see VerifyEmailCest::checkInvalidToken()
 * - @see VerifyEmailCest::checkNoToken()
 * - @see VerifyEmailCest::checkAlreadyActivatedToken()
 * - @see VerifyEmailCest::checkSuccessVerification()
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest
 *
 * @tag #frontend #tests #functional #VerifyEmailCest
 */
class VerifyEmailCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkEmptyToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/VerifyEmailCest.php#L27
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #_before
     */
    public function checkEmptyToken(FunctionalTester $I): void
    {
        $I->amOnRoute('auth/verify-email', ['token' => '']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Verify email token cannot be blank.');
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkInvalidToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/VerifyEmailCest.php#L41
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #checkInvalidToken
     */
    public function checkInvalidToken(FunctionalTester $I): void
    {
        $I->amOnRoute('auth/verify-email', ['token' => 'wrong_token']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Wrong verify email token.');
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkNoToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/VerifyEmailCest.php#L48
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #checkNoToken
     */
    public function checkNoToken(FunctionalTester $I): void
    {
        $I->amOnRoute('auth/verify-email');
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Missing required parameters: token');
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkAlreadyActivatedToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/VerifyEmailCest.php#L55
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #checkAlreadyActivatedToken
     */
    public function checkAlreadyActivatedToken(FunctionalTester $I): void
    {
        $I->amOnRoute('auth/verify-email', ['token' => 'already_used_token_1548675330']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Wrong verify email token.');
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkSuccessVerification
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #checkSuccessVerification
     */
    public function checkSuccessVerification(FunctionalTester $I): void
    {
        $I->amOnRoute('auth/verify-email', ['token' => '4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330']);
        $I->canSee('Your email has been confirmed!');
        $I->canSee('Congratulations!', 'h1');
        $I->see('Logout (test.test)', 'form button[type=submit]');

        $I->seeRecord('app\common\models\Identity', [
           'username' => 'test.test',
           'email' => 'test@mail.com',
           'status' => \app\common\models\Identity::STATUS_ACTIVE
        ]);
    }
}
