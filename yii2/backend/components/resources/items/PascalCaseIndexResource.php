<?php declare(strict_types=1);

namespace yii2\backend\components\resources\items;

use yii2\backend\models\search\items\PascalCaseSearch;
use yii2\backend\components\resources\parents\crud\BackendIndexResource;
use yii2\backend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Backend > Boilerplate для ресурса формы `PascalCase`
 *
 * @property PascalCaseSearch $searchModel;
 * @property PascalCaseDataProvider $activeDataProvider;
 *
 * @package app\backend\components\resources\items\{{snake_case}}
 *
 * @tag: #boilerplate #backend #resource #template #index
 */
class PascalCaseIndexResource extends BackendIndexResource
{
    // {{Boilerplate}}
}