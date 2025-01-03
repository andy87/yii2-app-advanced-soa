<?php declare(strict_types=1);

namespace frontend\tests\unit\services\items;

use frontend\services\items\PascalCaseService;
use common\components\base\services\items\source\SourceService;
use common\components\base\tests\unit\services\items\BaseServiceTest;

/**
 * < Frontend > PascalCaseServiceTest
 *
 * @property SourceService $service
 *
 * @package yii2\frontend\tests\unit\services\items
 *
 * @tag: #boilerplate #frontend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var SourceService|string класс сервиса */
    public SourceService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}