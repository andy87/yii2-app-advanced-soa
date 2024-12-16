<?php declare(strict_types=1);

namespace yii2\backend\tests\functional\items;

use yii2\backend\controllers\items\PascalCaseController;
use yii2\backend\tests\FunctionalTester;
use yii2\common\components\enums\Action;
use Codeception\Actor;
use functional\items\BaseWebControllerCest;

/**
 * < Backend > Тесты контроллера `PascalCaseController`
 *
 * @property  FunctionalTester $I
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest
 *
 * @package app\backend\tests\functional\items
 *
 * @tag: #boilerplate #backend #tests #functional #ContactCest
 */
class PascalCaseWebControllerCest extends BaseWebControllerCest
{
    /** @var string Для контроллера `UserGroupController` будет `user-group` */
    public const ENDPOINT = PascalCaseController::ENDPOINT;



    /**
     * Тестирование экшена `index` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkIndex
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @see \yii2\backend\controllers\items\PascalCaseController::actionIndex()
     */
    public function checkIndex( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::INDEX);

        //$I->see( $this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `create` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkCreate
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @see PascalCaseController::actionCreate()
     *
     * @tag: #boilerplate #backend #tests #functional #action #create
     */
    public function checkCreate( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::CREATE);

        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `update` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkUpdate
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @see PascalCaseController::actionUpdate()
     *
     * @tag: #boilerplate #backend #tests #functional #action #update
     */
    public function checkUpdate( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::UPDATE);

        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `view` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkView
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @see \yii2\backend\controllers\items\PascalCaseController::actionView()
     */
    public function checkView( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::VIEW);

        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `delete` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkDelete
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @see PascalCaseController::actionDelete()
     */
    public function checkDelete( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::DELETE);
        //redirect

        $I->canSeeResponseCodeIs(302);

    }
}
