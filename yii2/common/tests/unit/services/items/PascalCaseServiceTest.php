<?php declare(strict_types=1);

namespace common\tests\unit\services\items;

use common\components\base\services\items\BaseService;
use common\components\base\tests\unit\services\items\BaseServiceTest;

/**
 * < Common > PascalCaseServiceTest
 *
 * @package yii2\common\tests\unit\services\items
 *
 * @tag: #boilerplate #common #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var \common\components\base\services\items\BaseService|string класс сервиса */
    public BaseService|string $classNameService = \common\services\items\PascalCaseService::class;

    // {{Boilerplate}}
}