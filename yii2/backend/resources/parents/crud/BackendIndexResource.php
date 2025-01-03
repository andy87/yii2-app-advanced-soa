<?php declare(strict_types=1);

namespace backend\resources\parents\crud;

use common\components\base\dataProviders\items\source\SourceActiveDataProvider;
use common\components\base\resources\crud\BaseGridViewResource;
use common\components\interfaces\models\SearchModelInterface;

/**
 * < Backend > Родительский класс для ресурса индекса в окружении `backend`
 *
 * @property SourceActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\backend\components\resources\parents\crud
 *
 * @tag: #abstract #backend #parent #crud #resource #index
 */
abstract class BackendIndexResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}