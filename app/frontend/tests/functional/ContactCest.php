<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use Codeception\Scenario;
use app\frontend\tests\cest\SendForm;
use app\frontend\tests\FunctionalTester;
use Codeception\Exception\ModuleException;
use app\frontend\models\forms\ContactForm;
use app\frontend\controllers\SiteController;
use app\frontend\components\models\BaseWebForm;
use app\frontend\components\actions\CaptchaAction;
use yii\base\Theme;

/* @var $scenario Scenario */

/**
 * < Frontend > `ContactCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
 * @property ContactForm $form
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
class ContactCest extends SendForm
{
    /** @var BaseWebForm */
    protected const BASE_FORM_CLASS = ContactForm::class;

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
        parent::_before($I);

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
        $I->see( $this->form::TITLE, 'h1');
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
        $I->submitForm($this->formId, []);
        $I->see($this->form::TITLE, 'h1');
        $messages = [
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_NAME), $this->form::RULE_REQUIRED_MESSAGE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_EMAIL), $this->form::RULE_REQUIRED_MESSAGE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_SUBJECT), $this->form::RULE_REQUIRED_MESSAGE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_BODY), $this->form::RULE_REQUIRED_MESSAGE),
        ];
        foreach ($messages as $message) {
            $I->seeValidationError($message);
        }

        $I->seeValidationError($this->form::RULE_VERIFY_CODE_MESSAGE);
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
        $I->submitForm($this->formId, [
            "$this->formName[".ContactForm::ATTR_NAME."]" => 'tester',
            "$this->formName[".ContactForm::ATTR_EMAIL."]" => 'tester.email',
            "$this->formName[".ContactForm::ATTR_SUBJECT."]" => 'test subject',
            "$this->formName[".ContactForm::ATTR_BODY."]" => 'test content',
            "$this->formName[".ContactForm::ATTR_VERIFY_CODE."]" => CaptchaAction::TEST_VALUE,
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
        $I->submitForm($this->formId, [
            "$this->formName[".ContactForm::ATTR_NAME."]" => 'tester',
            "$this->formName[".ContactForm::ATTR_EMAIL."]" => 'tester@example.com',
            "$this->formName[".ContactForm::ATTR_SUBJECT."]" => 'test subject',
            "$this->formName[".ContactForm::ATTR_BODY."]" => 'test content',
            "$this->formName[".ContactForm::ATTR_VERIFY_CODE."]" => CaptchaAction::TEST_VALUE,
        ]);
        $I->seeEmailIsSent();
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }
}
