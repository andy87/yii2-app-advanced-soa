<?php declare(strict_types=1);

namespace frontend\resources\parents\crud;

use common\components\base\models\items\sources\SourceModel;

/**
 * < Frontend> Родительский класс для ресурса обновления модели в окружении `frontend`
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @property ?SourceModel $form
 *
 * @tag: #abstract #frontend #parent #crud #resource #update
 */
abstract class FrontendUpdateResource extends FrontendFormResource
{
    // {{Boilerplate}}
}