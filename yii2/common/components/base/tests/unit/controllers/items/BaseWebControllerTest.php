<?php declare(strict_types=1);

namespace yii2\common\components\base\tests\unit\controllers\items;

use yii\console\ExitCode;
use yii2\common\components\enums\Action;
use yii2\backend\controllers\items\PascalCaseController;
use yii2\common\components\base\tests\unit\controllers\items\BaseServiceControllerTest;

/**
 * < Common > Base Model Test
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/controllers/BaseControllerTest
 *
 * @property PascalCaseController $controller
 *
 * @package app\common\components\base\tests\unit
 *
 * @tag: #abstract #base #test #controllers
 */
abstract class BaseWebControllerTest extends BaseServiceControllerTest
{
    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/controllers/itemsPingTest:testVerb
     *
     * @return int
     */
    public function testVerb(): int
    {
        $verbList = $this->controller::VERBS;

        $this->assertNotEmpty($verbList , 'Список действий пуст');

        foreach ( $verbList as $action => $access )
        {
            $this->assertIsString($action, 'Действие не является строкой');
            $this->assertNotEmpty($access, 'Действие не имеет доступных методов');

            foreach ( $access as $verb )
            {
                $this->assertTrue(
                    in_array( $verb, Action::VERB),
                    "Действие: $action, не имеет доступа по методу: $verb"
                );
            }
        }

        return ExitCode::OK;
    }
}