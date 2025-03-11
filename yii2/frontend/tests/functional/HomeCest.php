<?php declare(strict_types=1);

namespace yii2\frontend\tests\functional;

use Yii;
use yii2\common\components\Action;
use yii2\frontend\components\Site;
use yii2\frontend\tests\FunctionalTester;
use yii2\frontend\controllers\SiteController;

/**
 * < Frontend > `HomeCest`
 *
 * @package yii2\frontend\tests\functional
 *
 * @property FunctionalTester $I
 *
 * Fix not used:
 * - @see HomeCest::checkOpen()
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/HomeCest
 *
 * @tag #frontend #tests #functional #HomeCest
 */
class HomeCest
{
    /**
     * Check open
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/functional/HomeCest:checkOpen
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
        $url = SiteController::constructUrl(Action::INDEX );

        /** @see SiteController::actionIndex() */
        $I->amOnRoute($url);

        $I->see( Yii::$app->name );
        $I->seeLink(SiteController::LABELS[Site::ACTION_ABOUT]);
        $I->click(SiteController::LABELS[Site::ACTION_ABOUT]);
        $I->see('Это страница О нас');
    }
}