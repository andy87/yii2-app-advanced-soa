<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\common\models\Identity;
use app\common\fixtures\UserFixture;
use app\frontend\tests\FunctionalTester;
use app\frontend\controllers\AuthController;

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
     * Check empty token
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkEmptyToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/VerifyEmailCest.php#L27
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see AuthController::actionVerifyEmail()
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #_before
     */
    public function checkEmptyToken(FunctionalTester $I): void
    {
        //[yii\base\InvalidArgumentException] Verify email token cannot be blank.
        $route = AuthController::ENDPOINT . '/' . AuthController::ACTION_VERIFY_EMAIL;
        $I->amOnRoute($route, ['token' => '']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Verify email token cannot be blank.');
    }

    /**
     * Check invalid token
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkInvalidToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/VerifyEmailCest.php#L41
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see AuthController::actionVerifyEmail()
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #checkInvalidToken
     */
    public function checkInvalidToken(FunctionalTester $I): void
    {
        // [yii\base\InvalidArgumentException] Wrong verify email token.
        $route = AuthController::ENDPOINT . '/' . AuthController::ACTION_VERIFY_EMAIL;

        $I->amOnRoute($route, ['token' => 'wrong_token']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Wrong verify email token.');
    }

    /**
     * Check no token
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkNoToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/VerifyEmailCest.php#L48
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see AuthController::actionVerifyEmail()
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #checkNoToken
     */
    public function checkNoToken(FunctionalTester $I): void
    {
        $route = AuthController::ENDPOINT . '/' . AuthController::ACTION_VERIFY_EMAIL;
        $I->amOnRoute($route);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Missing required parameters: token');
    }

    /**
     * Check already activated token
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkAlreadyActivatedToken
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/VerifyEmailCest.php#L55
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see AuthController::actionVerifyEmail()
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #checkAlreadyActivatedToken
     */
    public function checkAlreadyActivatedToken(FunctionalTester $I): void
    {
        //[yii\base\InvalidArgumentException] Wrong verify email token.
        $route = AuthController::ENDPOINT . '/' . AuthController::ACTION_VERIFY_EMAIL;
        $I->amOnRoute($route, ['token' => 'already_used_token_1548675330']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Wrong verify email token.');
    }

    /**
     * Check success verification
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/VerifyEmailCest:checkSuccessVerification
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see AuthController::actionVerifyEmail()
     *
     * @tag #frontend #tests #functional #VerifyEmailCest #checkSuccessVerification
     */
    public function checkSuccessVerification(FunctionalTester $I): void
    {
        //  Test  tests\functional\VerifyEmailCest.php:checkSuccessVerification
        // Step  Can see "Your email has been confirmed!"
        // Fail  Failed asserting that on page /index-test.php
        //-->  My Yii Application My Application Home About Contact Logout (test.test) Вы успешно подтвердили свой email! Congratulations! You have successfully created your Yii-powered application. Get started with Yii Heading Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidi
        //[Content too long to display. See complete response in 'W:\localhost\_self\github.com\yii2-app-advanced-soa\app\frontend\tests/_output\' directory]
        //--> contains "Your email has been confirmed!".
        $route = AuthController::ENDPOINT . '/' . AuthController::ACTION_VERIFY_EMAIL;
        $I->amOnRoute($route, ['token' => '4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330']);
        $I->canSee('Your email has been confirmed!');
        $I->canSee('Congratulations!', 'h1');
        $I->see('Logout (test.test)', 'form button[type=submit]');

        $I->seeRecord(Identity::class, [
           'username' => 'test.test',
           'email' => 'test@mail.com',
           'status' => Identity::STATUS_ACTIVE
        ]);
    }
}
