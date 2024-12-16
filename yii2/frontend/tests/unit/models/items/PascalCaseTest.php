<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models\items;

use yii2\common\components\base\{moels\items\base\SourceModel};
use yii2\frontend\models\items\PascalCase;
use unit\models\items\BaseModelTest;

/**
 * < Frontend > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method PascalCase testInspectAttributes()
 *
 * @package app\frontend\tests\unit\models\items
 *
 * @tag: #boilerplate #frontend #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    public SourceModel|string $modelClass = PascalCase::class;

    // {{Boilerplate}}
}