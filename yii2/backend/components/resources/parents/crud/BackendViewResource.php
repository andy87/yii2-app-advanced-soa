<?php declare(strict_types=1);

namespace yii2\backend\components\resources\parents\crud;


use yii2\common\components\base\models\items\base\SourceModel;
use yii2\common\components\base\resources\crud\BaseCrudViewResource;

/**
 * < Backend > Родительский класс для ресурса просмотра модели в окружении `backend`
 *
 * @property ?SourceModel $model
 *
 * @package app\backend\components\resources\parents\crud
 *
 * @tag: #abstract #backend #parent #crud #resource #view
 */
abstract class BackendViewResource extends \yii2\common\components\base\resources\crud\BaseCrudViewResource
{
    // {{Boilerplate}}
}