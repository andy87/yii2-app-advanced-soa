<?php declare(strict_types=1);

namespace yii2\backend\tests\unit\models\items;

use yii2\backend\models\items\PascalCase;
use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\tests\unit\models\items\BaseModelTest;


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