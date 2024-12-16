<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\services\items;

use yii2\common\components\base\{services\items\base\SourceService};
use yii2\frontend\components\services\items\PascalCaseService;
use unit\services\items\BaseServiceTest;

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
    public SourceService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}