<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\frontend\tests\FunctionalTester;
use ReflectionClass;

/**
 * < Frontend > `AboutCest`
 *
 * @package app\frontend\tests\functional
 *
 * @property FunctionalTester $I
 *
 * Fix not used:
 * - @see AboutCest::checkAbout()
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/AboutCest
 *
 * @tag #frontend #tests #functional #AboutCest
 */
class AboutCest
{
    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/AboutCest:checkAbout
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/AboutCest.php#L9
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #AboutCest #checkAbout
     */
    public function checkAbout(FunctionalTester $I): void
    {
        $I->amOnRoute('site/about');

        $I->see('About', 'h1');
    }
}
