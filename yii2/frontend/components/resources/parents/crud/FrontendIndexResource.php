<?php declare(strict_types=1);

namespace yii2\frontend\components\resources\parents\crud;

use yii2\common\components\interfaces\models\SearchModelInterface;
use yii2\common\components\base\resources\crud\BaseGridViewResource;
use yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Frontend> Родительский класс для ресурса индекса в окружении `frontend`
 *
 * @property \yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @tag: #abstract #frontend #parent #crud #resource #index
 */
abstract class FrontendIndexResource extends \yii2\common\components\base\resources\crud\BaseGridViewResource
{
    // {{Boilerplate}}
}