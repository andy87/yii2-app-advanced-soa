<?php declare(strict_types=1);

namespace frontend\producers\items;

use frontend\models\items\PascalCase;
use common\components\base\models\items\sources\SourceModel;

/**
 * < Frontend > producer for model `PascalCase`
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package yii2\frontend\components\services\producers\items
 *
 * @tag: #boilerplate #frontend #producer #{{snake_case}}
 */
class PascalCaseProducer extends \common\producers\items\PascalCaseProducer
{
    /** @var SourceModel|string $modelClass model class */
    public SourceModel|string $modelClass = PascalCase::class;
}