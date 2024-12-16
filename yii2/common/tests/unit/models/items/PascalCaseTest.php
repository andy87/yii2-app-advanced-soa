<?php declare(strict_types=1);

namespace yii2\common\tests\unit\models\items;

use yii2\common\components\base\moels\items\base\SourceModel;

/**
 * < Common > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method \yii2\common\models\items\PascalCase testInspectAttributes()
 *
 * @package app\common\tests\unit\models\items
 *
 * @tag: #boilerplate #common #test #model
 */
class PascalCaseTest extends \unit\models\items\BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    public SourceModel|string $modelClass = \yii2\common\models\items\PascalCase::class;

    // {{Boilerplate}}
}