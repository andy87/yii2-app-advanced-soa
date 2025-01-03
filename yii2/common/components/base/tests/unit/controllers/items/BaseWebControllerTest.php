<?php declare(strict_types=1);

namespace common\components\base\tests\unit\controllers\items;

use yii\console\ExitCode;
use common\components\enums\Action;
use backend\controllers\items\PascalCaseController;

/**
 * < Common > Base Model Test
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/controllers/BaseControllerTest
 *
 * @property PascalCaseController $controller
 *
 * @package yii2\common\components\base\tests\unit
 *
 * @tag: #abstract #base #test #controllers
 */
abstract class BaseWebControllerTest extends BaseServiceControllerTest
{
    /**
     * @cli ./vendor/bin/codecept run yii2/backend/tests/unit/controllers/itemsPingTest:testVerb
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
                $this->assertContains(
                    $verb,
                    Action::VERB,
                    "Действие: $action, не имеет доступа по методу: $verb"
                );
            }
        }

        return ExitCode::OK;
    }
}