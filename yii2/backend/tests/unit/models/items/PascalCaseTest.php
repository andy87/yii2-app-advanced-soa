<?php declare(strict_types=1);

namespace backend\tests\unit\models\items;

use backend\models\items\PascalCase;
use common\components\base\models\items\sources\SourceModel;
use common\components\base\tests\unit\models\items\BaseModelTest;


/**
 * < Backend > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method PascalCase testInspectAttributes()
 *
 * @package app\backend\tests\unit\models\items
 *
 * @tag: #boilerplate #backend #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    public SourceModel|string $modelClass = \yii2\backend\models\items\PascalCase::class;

    // {{Boilerplate}}
}