<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use Yii;
use app\frontend\tests\FunctionalTester;
use app\frontend\controllers\SiteController;

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
     * Check open
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/HomeCest:checkOpen
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/HomeCest.php#L9
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #HomeCest #checkOpen
     */
    public function checkOpen(FunctionalTester $I): void
    {
        /** @see SiteController::actionIndex() */
        $I->amOnRoute(Yii::$app->homeUrl);
        $I->see('My Application');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');
    }
}