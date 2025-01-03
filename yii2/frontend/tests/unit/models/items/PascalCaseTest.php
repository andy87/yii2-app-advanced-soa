<?php declare(strict_types=1);

namespace frontend\tests\unit\models\items;

use frontend\models\items\PascalCase;
use common\components\base\models\items\sources\SourceModel;
use common\components\base\tests\unit\models\items\BaseModelTest;

/**
 * < Frontend > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method PascalCase testInspectAttributes()
 *
 * @package yii2\frontend\tests\unit\models\items
 *
 * @tag: #boilerplate #frontend #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    public SourceModel|string $modelClass = PascalCase::class;

    // {{Boilerplate}}
}