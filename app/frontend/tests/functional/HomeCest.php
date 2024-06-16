<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use Yii;
use app\frontend\tests\FunctionalTester;

/**
 * < Frontend > `HomeCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
 *
 * Fix not used:
 * - @see HomeCest::checkOpen()
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/HomeCest
 *
 * @tag #frontend #tests #functional #HomeCest
 */
class HomeCest
{
    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/HomeCest:checkOpen
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #HomeCest #checkOpen
     */
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnRoute(Yii::$app->homeUrl);
        $I->see('My Application');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');
    }
}