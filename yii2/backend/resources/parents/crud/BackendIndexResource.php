<?php declare(strict_types=1);

namespace backend\resources\parents\crud;

use yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider;
use yii2\common\components\base\resources\crud\BaseGridViewResource;
use yii2\common\components\interfaces\models\SearchModelInterface;

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