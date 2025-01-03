<?php declare(strict_types=1);

namespace yii2\backend\tests\unit\services\items;

use unit\services\items\BaseServiceTest;
use yii2\common\components\base\{services\items\base\SourceService};

/**
 * < Backend > PascalCaseServiceTest
 *
 * @property SourceService $service
 *
 * @package app\backend\tests\unit\services\items
 *
 * @tag: #boilerplate #backend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var SourceService|string класс сервиса */
    public SourceService|string $classnameService = \backend\services\items\PascalCaseService::class;

    // {{Boilerplate}}
}