<?php declare(strict_types=1);

namespace yii2\frontend\tests\functional;

use yii2\common\components\Layout;
use yii2\common\models\Identity;
use yii2\common\fixtures\UserFixture;
use yii2\common\models\sources\User;
use yii2\frontend\tests\FunctionalTester;
use yii2\frontend\controllers\AuthController;
use yii2\frontend\models\forms\VerifyEmailForm;

/**
 * < Frontend > `VerifyEmailCest`
 *
 * @package yii2\frontend\tests\functional
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
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/VerifyEmailCest
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
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/VerifyEmailCest:checkEmptyToken
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
        $I->amOnRoute($this->getRoute(), ['token' => '']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee(VerifyEmailForm::EXCEPTION_TOKEN_EMPTY);
    }

    /**
     * Check invalid token
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/VerifyEmailCest:checkInvalidToken
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
        $I->amOnRoute($this->getRoute(), ['token' => 'wrong_token']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee(VerifyEmailForm::EXCEPTION_TOKEN_INVALID);
    }

    /**
     * Check no token
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/VerifyEmailCest:checkNoToken
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
        $I->amOnRoute($this->getRoute());
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Missing required parameters: token');
    }

    /**
     * Check already activated token
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/VerifyEmailCest:checkAlreadyActivatedToken
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
        $I->amOnRoute($this->getRoute(), ['token' => 'already_used_token_1548675330']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Wrong verify email token.');
    }

    /**
     * Check success verification
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/VerifyEmailCest:checkSuccessVerification
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
        $I->amOnRoute( $this->getRoute(), ['token' => '4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330']);
        $I->canSee(VerifyEmailForm::MESSAGE_SUCCESS);
        $I->canSee('Congratulations!', 'h1');
        $I->see(Layout::BUTTON_TEXT_LOGOUT . ' (test.test)', 'form button[type=submit]');

        $I->seeRecord(Identity::class, [
            User::ATTR_USERNAME => 'test.test',
            User::ATTR_EMAIL => 'test@mail.com',
            User::ATTR_STATUS => Identity::STATUS_ACTIVE
        ]);
    }

    /**
     * @endpoint auth/verify-email
     *
     * @return string
     */
    private function getRoute(): string
    {
        return AuthController::getEndpoint(AuthController::ACTION_VERIFY_EMAIL);
    }
}
