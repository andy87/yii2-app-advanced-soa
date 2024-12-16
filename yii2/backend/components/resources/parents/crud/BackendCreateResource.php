<?php declare(strict_types=1);

namespace yii2\backend\components\resources\parents\crud;

use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\backend\components\resources\parents\crud\BackendFormResource;

/**
 * < Backend > Родительский класс для ресурса создания модели в окружении `backend`
 *
 * @property ?\yii2\common\components\base\models\items\sources\SourceModel $form
 * 
 * @package app\backend\components\resources\parents\crud
 *
 * @tag: #abstract #backend #parent #crud #resource #create
 */
abstract class BackendCreateResource extends BackendFormResource
{
    // {{Boilerplate}}
}