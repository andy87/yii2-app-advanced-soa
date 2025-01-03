<?php declare(strict_types=1);

namespace frontend\resources\parents\crud;

use yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider;
use yii2\common\components\base\resources\crud\BaseGridViewResource;
use yii2\common\components\interfaces\models\SearchModelInterface;

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