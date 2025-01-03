<?php declare(strict_types=1);

namespace common\components\base\tests\unit\controllers\items;

use Yii;
use yii\base\Behavior;
use yii\console\ExitCode;
use yii\base\InvalidConfigException;
use backend\controllers\items\PascalCaseController;
use common\interfaces\controllers\ControllerHandlerInterface;
use common\components\base\handlers\items\source\SourceHandler;
use common\components\base\tests\unit\source\items\BaseUnitTest;

/**
 * < Common > Base Model Test
 *
 * @package yii2\common\components\base\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/controllers/BaseControllerTest
 *
 * @tag: #abstract #base #test #controllers
 */
abstract class BaseServiceControllerTest extends BaseUnitTest
{
    /** @var PascalCaseController $controller */
    public PascalCaseController $controller;



    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function _before(): void
    {
        /** @var PascalCaseController $controller */
        $controller = Yii::createObject([
            'class' => PascalCaseController::class
        ]);

        $this->controller = $controller;
    }

    /**
     * @cli ./vendor/bin/codecept run yii2/backend/tests/unit/controllers/itemsPingTest:testSetupHandler
     *
     * @return int
     */
    public function testSetupHandler(): int
    {
        $this->assertInstanceOf(ControllerHandlerInterface::class, $this->controller);

        $this->assertInstanceOf( SourceHandler::class, $this->controller->handler);

        $this->assertTrue($this->controller->setupHandler());

        return ExitCode::OK;
    }

    /**
     * @cli ./vendor/bin/codecept run yii2/backend/tests/unit/controllers/itemsPingTest:testBehavior
     *
     * @return int
     */
    public function testBehavior(): int
    {
        $this->assertInstanceOf(ControllerHandlerInterface::class, $this->controller);

        $behaviors = $this->controller->behaviors();

        if(count($behaviors))
        {
            foreach ( $behaviors as $behavior )
            {
                $this->assertInstanceOf( Behavior::class, $behavior, 'Поведение не является объектом `Behavior`' );

            }
        }

        return ExitCode::OK;
    }
}