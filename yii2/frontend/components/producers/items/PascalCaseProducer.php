<?php declare(strict_types=1);

namespace yii2\frontend\components\producers\items;

use yii2\frontend\models\items\PascalCase;
use yii2\common\components\base\models\items\sources\SourceModel;

/**
 * < Frontend > producer for model `PascalCase`
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\frontend\components\services\producers\items
 *
 * @tag: #boilerplate #frontend #producer #{{snake_case}}
 */
class PascalCaseProducer extends \yii2\common\components\producers\items\PascalCaseProducer
{
    /** @var SourceModel|string $modelClass model class */
    public SourceModel|string $modelClass = PascalCase::class;
}