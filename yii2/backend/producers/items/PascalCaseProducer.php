<?php declare(strict_types=1);

namespace backend\producers\items;

use backend\models\items\PascalCase;
use common\components\base\models\items\sources\SourceModel;

/**
 * < Backend > producer for model `PascalCase`
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\backend\components\services\producers\items
 *
 * @tag: #boilerplate #backend #producer #{{snake_case}}
 */
class PascalCaseProducer extends \common\producers\items\PascalCaseProducer
{
    /** @var SourceModel|string $modelClass model class */
    public SourceModel|string $modelClass = PascalCase::class;
}