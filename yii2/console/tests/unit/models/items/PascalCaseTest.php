<?php declare(strict_types=1);

namespace console\tests\unit\models\items;

use common\components\base\{moels\items\base\SourceModel};
use console\models\items\PascalCase;
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