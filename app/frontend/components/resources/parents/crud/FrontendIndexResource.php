<?php declare(strict_types=1);

namespace app\frontend\components\resources\parents\crud;

use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\base\services\resources\crud\BaseGridViewResource;
use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Frontend> Родительский класс для ресурса индекса в окружении `frontend`
 *
 * @property SourceActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @tag: #abstract #frontend #parent #crud #resource #index
 */
abstract class FrontendIndexResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}