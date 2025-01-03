<?php declare(strict_types=1);

namespace yii2\common\tests\unit\services\items;

use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\base\tests\unit\services\items\BaseServiceTest;

/**
 * < Common > PascalCaseServiceTest
 *
 * @package app\common\tests\unit\services\items
 *
 * @tag: #boilerplate #common #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var \yii2\common\components\base\services\items\BaseService|string класс сервиса */
    public BaseService|string $classNameService = \common\services\items\PascalCaseService::class;

    // {{Boilerplate}}
}