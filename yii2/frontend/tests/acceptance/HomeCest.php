<?php declare(strict_types=1);

namespace yii2\frontend\tests\acceptance;

use Yii;
use yii\helpers\Url;
use yii2\common\components\Action;
use yii2\frontend\components\Site;
use yii2\frontend\controllers\SiteController;
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
        $url = Url::toRoute('/' . SiteController::ENDPOINT . '/' . Action::INDEX );

        $I->amOnRoute($url);
        $I->see(Yii::$app->name);

        $link = Site::LABELS[Site::ACTION_ABOUT];

        $I->seeLink($link);
        $I->click($link);
        $I->wait(2); // wait for page to be opened

        $I->see('This is the About page.');
    }
}
