<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\frontend\tests\FunctionalTester;
use app\frontend\models\forms\ContactForm;
use app\frontend\controllers\SiteController;
use Codeception\Exception\ModuleException;

/* @var $scenario \Codeception\Scenario */

/**
 * < Frontend > `ContactCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
 *
 * Fix not used:
 * - @see ContactCest::checkContact()
 * - @see ContactCest::checkContactSubmitNoData()
 * - @see ContactCest::checkContactSubmitNotCorrectEmail()
 * - @see ContactCest::checkContactSubmitCorrectData()
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ContactCest
 *
 * @tag #frontend #tests #functional #ContactCest
 */
class ContactCest
{
    /**
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see SiteController::actionContact()
     *
     * @tag #frontend #tests #functional #ContactCest #checkContact
     */
    public function _before(FunctionalTester $I): void
    {
        $route = SiteController::ENDPOINT . '/' . SiteController::ACTION_CONTACT;

        $I->amOnRoute($route);
    }

    /**
     * Check contact
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ContactCest:checkContact
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ContactCest.php#L16
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ContactCest #checkContact
     */
    public function checkContact(FunctionalTester $I): void
    {
        $I->see('Contact', 'h1');
    }

    /**
     * Check contact submit no data
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ContactCest:checkContactSubmitNoData
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ContactCest.php#L21
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ContactCest #checkContactSubmitNoData
     */
    public function checkContactSubmitNoData(FunctionalTester $I): void
    {
        $I->submitForm('#'  . ContactForm::ID, []);
        $I->see('Contact', 'h1');
        $I->seeValidationError('Name cannot be blank');
        $I->seeValidationError('Email cannot be blank');
        $I->seeValidationError('Subject cannot be blank');
        $I->seeValidationError('Body cannot be blank');
        $I->seeValidationError('The verification code is incorrect');
    }

    /**
     * Check contact submit not correct email
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ContactCest:checkContactSubmitNotCorrectEmail
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ContactCest.php#L32
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ContactCest #checkContactSubmitNotCorrectEmail
     */
    public function checkContactSubmitNotCorrectEmail(FunctionalTester $I): void
    {
        $I->submitForm('#'  . ContactForm::ID, [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeValidationError('Email is not a valid email address.');
        $I->dontSeeValidationError('Name cannot be blank');
        $I->dontSeeValidationError('Subject cannot be blank');
        $I->dontSeeValidationError('Body cannot be blank');
        $I->dontSeeValidationError('The verification code is incorrect');
    }

    /**
     * Check contact submit correct data
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ContactCest:checkContactSubmitCorrectData
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ContactCest.php#L48
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @throws ModuleException
     *
     * @tag #frontend #tests #functional #ContactCest #checkContactSubmitCorrectData
     */
    public function checkContactSubmitCorrectData(FunctionalTester $I): void
    {
        $I->submitForm('#'  . ContactForm::ID, [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeEmailIsSent();
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }
}
