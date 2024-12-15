<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use Codeception\Test\Unit;
use yii2\common\components\Ping;
use yii2\frontend\tests\UnitTester;

/**
 * < Frontend > `PingTest`
 *
 * @package yii2\frontend\tests\unit\models
 *
 * @property UnitTester $tester
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/PingTest
 *
 * @tag #tests #unit #models #PingTest
 */
class PingTest extends Unit
{
    /**
     * Ping test
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/PingTest:testPong
     *
     * @return void
     *
     * @tag #frontend #tests #unit #models #ContactFormTest #testSendEmail
     */
    public function testPong(): void
    {
        verify((new Ping)->run())->equals(Ping::ANSWER);
    }
}
