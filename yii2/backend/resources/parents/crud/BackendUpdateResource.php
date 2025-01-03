<?php declare(strict_types=1);

namespace backend\resources\parents\crud;

use backend\models\forms\items\PascalCaseForm;

/**
 * < Backend > Родительский класс для ресурса создания модели в окружении `backend`
 *
 * @property ?PascalCaseForm $form
 * 
 * @package app\backend\components\resources\parents\crud
 *
 * @tag: #abstract #backend #parent #crud #resource #update
 */
abstract class BackendUpdateResource extends BackendFormResource
{
    // {{Boilerplate}}
}