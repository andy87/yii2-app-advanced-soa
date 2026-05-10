<?php

declare(strict_types=1);

namespace yii2\frontend\tests;

/**
 * Actor для frontend integration-тестов.
 *
 * @SuppressWarnings(PHPMD)
 */
class IntegrationTester extends \Codeception\Actor
{
    use _generated\IntegrationTesterActions;
}
