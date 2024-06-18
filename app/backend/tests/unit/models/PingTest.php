<?php declare(strict_types=1);

namespace app\backend\tests\unit\models;

use Codeception\Test\Unit;
use app\common\components\Ping;
use app\backend\tests\UnitTester;

/**
 * < Backend > `PingTest`
 *
 * @package app\backend\tests\unit\modules
 *
 * @property UnitTester $tester
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/unit/models/PingTest
 *
 * @tag #tests #unit #models #PingTest
 */
class PingTest extends Unit
{
    /**
     * Ping test
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/models/PingTest:testPong
     *
     * @return void
     *
     * @tag #backend #tests #unit #models #ContactFormTest #testSendEmail
     */
    public function testPong(): void
    {
        verify((new Ping)->run())->equals(Ping::ANSWER);
    }
}
