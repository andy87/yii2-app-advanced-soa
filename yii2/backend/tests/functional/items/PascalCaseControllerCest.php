<?php declare(strict_types=1);

namespace backend\tests\functional\items;

use Codeception\Actor;
use backend\tests\FunctionalTester;
use common\components\enums\Action;
use backend\controllers\items\PascalCaseController;
use common\components\base\tests\functional\items\BaseWebControllerCest;

/**
 * < Backend > Тесты контроллера `PascalCaseController`
 *
 * @property  FunctionalTester $I
 *
 * @cli ./vendor/bin/codecept run yii2/backend/tests/functional/items/PascalCaseControllerCest
 *
 * @package yii2\backend\tests\functional\items
 *
 * @tag: #boilerplate #backend #tests #functional #ContactCest
 */
class PascalCaseControllerCest extends BaseWebControllerCest
{
    /** @var string Для контроллера `UserGroupController` будет `user-group` */
    public const string ENDPOINT = PascalCaseController::ENDPOINT;

    /**
     * Тестирование экшена `index` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run yii2/backend/tests/functional/items/PascalCaseControllerCest:checkIndex
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @see PascalCaseController::actionIndex
     */
    public function checkIndex( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::INDEX);

        $I->see(PascalCaseController::LABELS[Action::INDEX], 'h1');
    }

    /**
     * Тестирование экшена `create` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run yii2/backend/tests/functional/items/PascalCaseControllerCest:checkCreate
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

        $I->see(PascalCaseController::LABELS[Action::CREATE], 'h1');
    }

    /**
     * Тестирование экшена `update` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run yii2/backend/tests/functional/items/PascalCaseControllerCest:checkUpdate
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

        $I->see(PascalCaseController::LABELS[Action::UPDATE], 'h1');
    }

    /**
     * Тестирование экшена `view` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run yii2/backend/tests/functional/items/PascalCaseControllerCest:checkView
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @see PascalCaseController::actionView()
     */
    public function checkView( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::VIEW);

        $I->see(PascalCaseController::LABELS[Action::VIEW], 'h1');
    }

    /**
     * Тестирование экшена `delete` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run yii2/backend/tests/functional/items/PascalCaseControllerCest:checkDelete
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

        $I->canSeeResponseCodeIs(302);
    }
}
