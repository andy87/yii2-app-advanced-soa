<?php declare(strict_types=1);

namespace backend\resources\items;

use backend\dataProviders\items\PascalCaseDataProvider;
use backend\resources\parents\crud\BackendIndexResource;
use backend\models\search\items\PascalCaseSearch;

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