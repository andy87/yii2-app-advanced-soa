<?php declare(strict_types=1);

namespace yii2\frontend\components\resources\parents\crud;

use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\frontend\components\resources\parents\crud\FrontendFormResource;

/**
 * < Frontend> Родительский класс для ресурса создания модели в окружении `frontend`
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @property ?\yii2\common\components\base\models\items\sources\SourceModel $form
 *
 * @tag: #abstract #frontend #parent #crud #resource #create
 */
abstract class FrontendCreateResource extends FrontendFormResource
{
    // {{Boilerplate}}
}