<?php declare(strict_types=1);

namespace frontend\tests\unit\services\items;

use unit\services\items\BaseServiceTest;
use common\components\base\{services\items\base\SourceService};

/**
 * < Frontend > PascalCaseServiceTest
 *
 * @property SourceService $service
 *
 * @package app\frontend\tests\unit\services\items
 *
 * @tag: #boilerplate #frontend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var SourceService|string класс сервиса */
    public SourceService|string $classnameService = \frontend\services\items\PascalCaseService::class;

    // {{Boilerplate}}
}