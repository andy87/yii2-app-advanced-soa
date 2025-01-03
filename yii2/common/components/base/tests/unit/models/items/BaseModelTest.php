<?php declare(strict_types=1);

namespace common\components\base\tests\unit\models\items;

use yii\console\ExitCode;
use yii\base\InvalidConfigException;
use common\components\base\models\items\sources\SourceModel;
use common\components\base\tests\unit\source\items\BaseUnitTest;

/**
 * < Common > Base Model Test
 *
 * @package app\common\components\base\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/models/BaseModelTest
 *
 * @tag: #abstract #base #test #model
 */
abstract class BaseModelTest extends \yii2\common\components\base\tests\unit\source\items\BaseUnitTest
{
    /** @var SourceModel|string $modelClass */
    public SourceModel|string $modelClass;



    /**
     * Проверка соответствия атрибутов модели и колонок таблицы
     *
     * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/models/BaseModelTest:testInspectAttributes
     *
     * @return int
     *
     * @throws InvalidConfigException
     */
    public function testInspectAttributes(): int
    {
        $modelClass = $this->modelClass;

        /** @var SourceModel $model */
        $model = new $modelClass();

        $attributes = array_keys($model->attributes());

        $columns = $model->getTableSchema()->columns;

        $this->assertEquals( $attributes, array_column($columns,'name') );

        $notNullColumns = array_filter($columns, function($column) {
            return !$column->allowNull;
        });

        $requiredAttributes = $this->getRequiredAttributes($model);

        foreach (array_column($notNullColumns, 'name') as $columnName )
        {
            $this->assertContains($columnName, $requiredAttributes);
        }

        return ExitCode::OK;
    }

    /**
     * @param SourceModel $model
     *
     * @return array
     */
    private function getRequiredAttributes(SourceModel $model ): array
    {
        $rules = $model->rules();

        $attributes = [];

        foreach ($rules as $rule) {
            if (is_array($rule) && $rule[1] === 'required') {
                $attributes = array_merge($attributes, $rule[0]);
            }
        }

        return $attributes;
    }
}