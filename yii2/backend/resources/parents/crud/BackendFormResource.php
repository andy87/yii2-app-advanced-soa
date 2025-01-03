<?php declare(strict_types=1);

namespace backend\resources\parents\crud;

use backend\models\forms\items\PascalCaseForm;
use common\components\base\resources\crud\BaseFormResource;

/**
 * < Backend > Родительский класс для ресурса с формой в окружении `backend`
 *
 * @property ?PascalCaseForm $form
 *
 * @package app\backend\components\resources\parents\crud
 *
 * @tag: #abstract #backend #parent #crud #resource #form
 */
abstract class BackendFormResource extends BaseFormResource
{
    // {{Boilerplate}}
}