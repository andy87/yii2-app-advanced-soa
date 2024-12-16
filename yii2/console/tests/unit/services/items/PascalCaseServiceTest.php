<?php declare(strict_types=1);

namespace yii2\console\tests\unit\services\items;

use yii2\console\tests\unit\services\items\SourceService;
use yii2\console\components\services\items\PascalCaseService;

/**
 * < Console > PascalCaseServiceTest
 *
 * @property SourceService $service
 *
 * @package app\console\tests\unit\services\items
 *
 * @tag: #boilerplate #console #test #service
 */
class PascalCaseServiceTest extends \unit\services\items\BaseServiceTest
{
    /** @var SourceService|string класс сервиса */
    public SourceService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}