<?php declare(strict_types=1);

namespace common\producers\items;

use common\components\base\models\items\sources\SourceModel;
use common\components\base\producers\items\source\SourceProducer;
use common\models\items\PascalCase;

/**
 * < Common > Родительский класс для продюсеров: console/frontend/backend
 *
 * @method PascalCase createModel(array $params = [], bool $runSave = false)
 * @method \yii2\common\models\items\PascalCase addModel(array $params)
 *
 * @package yii2\app\common\services\components\services\producers\items
 *
 * @tag: #boilerplate #common #producer #{{snake_case}}
 */
class PascalCaseProducer extends SourceProducer
{
    /** @var \common\components\base\models\items\sources\SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = PascalCase::class;
}