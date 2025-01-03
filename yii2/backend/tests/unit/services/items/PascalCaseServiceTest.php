<?php declare(strict_types=1);

namespace backend\tests\unit\services\items;

use backend\services\items\PascalCaseService;
use common\components\base\services\items\source\SourceService;
use common\components\base\tests\unit\services\items\BaseServiceTest;

/**
 * < Backend > PascalCaseServiceTest
 *
 * @property SourceService $service
 *
 * @package yii2\backend\tests\unit\services\items
 *
 * @tag: #boilerplate #backend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var SourceService|string класс сервиса */
    public SourceService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}