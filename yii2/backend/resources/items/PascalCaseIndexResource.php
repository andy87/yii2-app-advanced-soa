<?php declare(strict_types=1);

namespace backend\resources\items;

use backend\models\search\items\PascalCaseSearch;
use backend\dataProviders\items\PascalCaseDataProvider;
use backend\resources\parents\crud\BackendIndexResource;

/**
 * < Backend > Boilerplate для ресурса формы `PascalCase`
 *
 * @property PascalCaseSearch $searchModel;
 * @property PascalCaseDataProvider $activeDataProvider;
 *
 * @package yii2\backend\components\resources\items\{{snake_case}}
 *
 * @tag: #boilerplate #backend #resource #template #index
 */
class PascalCaseIndexResource extends BackendIndexResource
{
    // {{Boilerplate}}
}