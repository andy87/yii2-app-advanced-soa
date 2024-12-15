<?php declare(strict_types=1);

namespace yii2\frontend\tests\functional;

use yii2\frontend\tests\FunctionalTester;
use yii2\frontend\controllers\SiteController;

/**
 * < Frontend > `AboutCest`
 *
 * @package yii2\frontend\tests\functional
 *
 * @property FunctionalTester $I
 *
 * Fix not used:
 * - @see AboutCest::checkAbout()
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/AboutCest
 *
 * @tag #frontend #tests #functional #AboutCest
 */
class AboutCest
{
    /**
     * Check about
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/AboutCest:checkAbout
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/AboutCest.php#L9
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see SiteController::actionAbout()
     *
     * @tag #frontend #tests #functional #AboutCest #checkAbout
     */
    public function checkAbout(FunctionalTester $I): void
    {
        $I->amOnRoute(SiteController::ENDPOINT . '/' . SiteController::ACTION_ABOUT);

        $I->see(SiteController::LABELS[SiteController::ACTION_ABOUT], 'h1');
    }
}
