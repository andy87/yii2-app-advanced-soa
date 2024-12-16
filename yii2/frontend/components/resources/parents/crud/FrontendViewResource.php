<?php declare(strict_types=1);

namespace yii2\frontend\components\resources\parents\crud;

use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\resources\crud\BaseCrudViewResource;

/**
 * < Frontend> Родительский класс для ресурса просмотра модели в окружении `frontend`
 *
 * @property ?\yii2\common\components\base\models\items\sources\SourceModel $model
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @tag: #abstract #frontend #parent #crud #resource #view
 */
abstract class FrontendViewResource extends \yii2\common\components\base\resources\crud\BaseCrudViewResource
{
    // {{Boilerplate}}
}