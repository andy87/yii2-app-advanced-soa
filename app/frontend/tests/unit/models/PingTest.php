<?php declare(strict_types=1);

namespace app\frontend\tests\unit\models;

use Codeception\Test\Unit;
use app\common\components\Ping;
use app\frontend\tests\UnitTester;

/**
 * < Backend > `PingTest`
 *
 * @package app\backend\tests\unit\modules
 *
 * @property UnitTester $tester
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/PingTest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ContactFormTest.php
 *
 * @tag #tests #unit #models #ContactFormTest
 */
class PingTest extends Unit
{
    /**
     * Send email
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/PingTest:testPong
     *
     * @return void
     *
     *
     * @tag #frontend #tests #unit #models #ContactFormTest #testSendEmail
     */
    public function testPong(): void
    {
        verify((new Ping)->run())->equals(Ping::ANSWER);
    }
}