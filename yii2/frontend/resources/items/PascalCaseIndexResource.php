<?php declare(strict_types=1);

namespace frontend\resources\items;

use frontend\dataProviders\items\PascalCaseDataProvider;
use frontend\resources\parents\crud\FrontendIndexResource;
use yii2\frontend\models\search\items\PascalCaseSearch;

/**
 * < Frontend > Boilerplate для ресурса формы `PascalCase`
 *
 * @property PascalCaseSearch $searchModel;
 * @property \frontend\dataProviders\items\PascalCaseDataProvider $activeDataProvider;
 *
 * @package app\frontend\resources\items\{{snake_case}}
 *
 * @tag: #boilerplate #frontend #resource #template #index
 */
class PascalCaseIndexResource extends FrontendIndexResource
{
    // {{Boilerplate}}
}