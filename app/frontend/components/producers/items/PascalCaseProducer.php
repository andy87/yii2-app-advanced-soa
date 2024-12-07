<?php declare(strict_types=1);

namespace app\frontend\components\producers\items;

use app\frontend\models\items\PascalCase;
use app\common\components\base\models\items\sources\SourceModel;

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
class PascalCaseProducer extends \app\common\components\producers\items\PascalCaseProducer
{
    /** @var SourceModel|string $modelClass model class */
    public SourceModel|string $modelClass = PascalCase::class;
}