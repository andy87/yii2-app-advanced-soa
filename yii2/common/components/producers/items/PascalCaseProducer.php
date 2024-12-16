<?php declare(strict_types=1);

namespace yii2\common\components\producers\items;

use yii2\common\models\items\PascalCase;
use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\producers\items\source\SourceProducer;

/**
 * < Common > Родительский класс для продюсеров: console/frontend/backend
 *
 * @method PascalCase createModel(array $params = [], bool $runSave = false)
 * @method \yii2\common\models\items\PascalCase addModel(array $params)
 *
 * @package app\app\common\services\components\services\producers\items
 *
 * @tag: #boilerplate #common #producer #{{snake_case}}
 */
class PascalCaseProducer extends SourceProducer
{
    /** @var \yii2\common\components\base\models\items\sources\SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = PascalCase::class;
}