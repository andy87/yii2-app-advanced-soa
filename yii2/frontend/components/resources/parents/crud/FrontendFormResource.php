<?php declare(strict_types=1);

namespace yii2\frontend\components\resources\parents\crud;

use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\resources\crud\BaseFormResource;

/**
 * < Frontend> Родительский класс для ресурса с формой в окружении `frontend`
 *
 * @property ?\yii2\common\components\base\models\items\sources\SourceModel $form
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @tag: #abstract #frontend #parent #crud #resource #form
 */
abstract class FrontendFormResource extends \yii2\common\components\base\resources\crud\BaseFormResource
{
    // {{Boilerplate}}
}