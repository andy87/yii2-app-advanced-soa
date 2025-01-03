<?php declare(strict_types=1);

namespace common\tests\unit\models\items;

use common\components\base\tests\unit\models\items\BaseModelTest;
use common\models\items\PascalCase;
use common\components\base\models\items\sources\SourceModel;

/**
 * < Common > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method PascalCase testInspectAttributes()
 *
 * @package yii2\common\tests\unit\models\items
 *
 * @tag: #boilerplate #common #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    public SourceModel|string $modelClass = \common\models\items\PascalCase::class;

    // {{Boilerplate}}
}