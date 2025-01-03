<?php declare(strict_types=1);

namespace frontend\producers\items;

use common\components\base\models\items\sources\SourceModel;
use frontend\models\items\PascalCase;

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
class PascalCaseProducer extends \common\producers\items\PascalCaseProducer
{
    /** @var SourceModel|string $modelClass model class */
    public SourceModel|string $modelClass = PascalCase::class;
}