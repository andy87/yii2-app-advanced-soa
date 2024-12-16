<?php declare(strict_types=1);

namespace yii2\common\components\base\tests\unit\services\items;

use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\traits\services\ApplyServiceTrait;
use yii2\common\components\base\tests\unit\source\items\BaseUnitTest;

/**
 * < Common > Base Service Test
 *
 * @property BaseService $service
 * @property BaseService|string $classnameService
 *
 * @package app\common\components\base\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/service/BaseServiceTest
 *
 * @tag: #abstract #base #test #service
 */
abstract class BaseServiceTest extends \yii2\common\components\base\tests\unit\source\items\BaseUnitTest
{
    use ApplyServiceTrait;

    // {{Parent}}
}