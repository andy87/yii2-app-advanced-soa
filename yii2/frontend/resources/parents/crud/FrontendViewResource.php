<?php declare(strict_types=1);

namespace frontend\resources\parents\crud;

use common\components\base\models\items\sources\SourceModel;
use common\components\base\resources\crud\BaseCrudViewResource;

/**
 * < Frontend> Родительский класс для ресурса просмотра модели в окружении `frontend`
 *
 * @property ?SourceModel $model
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @tag: #abstract #frontend #parent #crud #resource #view
 */
abstract class FrontendViewResource extends BaseCrudViewResource
{
    // {{Boilerplate}}
}