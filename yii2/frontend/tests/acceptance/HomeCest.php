<?php declare(strict_types=1);

namespace yii2\frontend\tests\acceptance;

use yii\helpers\Url;
use yii2\frontend\tests\AcceptanceTester;

/**
 * < Frontend > `HomeCest`
 *
 * @package yii2\frontend\tests\acceptance
 *
 * @property AcceptanceTester $I
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/acceptance/HomeCest
 *
 * @tag #frontend #tests #acceptance #HomeCest
 */
class HomeCest
{
    /**
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/acceptance/HomeCest:checkHome
     *
     * @param AcceptanceTester $I
     *
     * @return void
     */
    public function checkHome(AcceptanceTester $I): void
    {
        $I->amOnRoute(Url::toRoute('/site/index'));
        $I->see('My Application');

        $I->seeLink('About');
        $I->click('About');
        $I->wait(2); // wait for page to be opened

        $I->see('This is the About page.');
    }
}
