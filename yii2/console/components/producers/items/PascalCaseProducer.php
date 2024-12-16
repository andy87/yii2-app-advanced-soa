<?php declare(strict_types=1);

namespace yii2\console\components\producers\items;

use yii2\console\models\items\PascalCase;
use yii2\common\components\base\models\items\sources\SourceModel;

/**
 * < Console > producer for model `PascalCase`
 *
 * @method \yii2\console\models\items\PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\console\components\services\producers\items
 *
 * @tag: #boilerplate #console #producer #{{snake_case}}
 */
class PascalCaseProducer extends \yii2\common\components\producers\items\PascalCaseProducer
{
    /** @var SourceModel|string $modelClass model class */
    public SourceModel|string $modelClass = PascalCase::class;
}