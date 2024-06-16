<?php declare(strict_types=1);

namespace app\frontend\tests\functional;

use app\frontend\tests\FunctionalTester;
use app\frontend\tests\_generated\FunctionalTesterActions;

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
    use FunctionalTesterActions;

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/AboutCest:checkAbout
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

    /**
     * @return string[]
     */
    protected function getScenario(): array
    {
        return [
            'scenario' => 'AboutCest',
        ];
    }
}
