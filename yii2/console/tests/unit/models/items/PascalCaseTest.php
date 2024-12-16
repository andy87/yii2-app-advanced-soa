<?php declare(strict_types=1);

namespace yii2\console\tests\unit\models\items;

use yii2\common\components\base\{moels\items\base\SourceModel};
use yii2\console\models\items\PascalCase;
use unit\models\items\BaseModelTest;

/**
 * < Console > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/console/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/console/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method PascalCase testInspectAttributes()
 *
 * @package app\console\tests\unit\models\items
 *
 * @tag: #boilerplate #console #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    public SourceModel|string $modelClass = \yii2\console\models\items\PascalCase::class;

    // {{Boilerplate}}
}