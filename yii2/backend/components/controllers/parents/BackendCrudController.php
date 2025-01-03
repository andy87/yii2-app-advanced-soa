<?php declare(strict_types=1);

namespace backend\components\controllers\parents;

use common\components\traits\controllers\CrudTrait;
use common\components\traits\handlers\BackendHandler;

/**
 * < Backend > Родительский класс для контроллеров в окружении: `backend`
 *
 * @property BackendHandler $handler
 * @property array $resources
 *
 * @package yii2\backend\components\controllers\parents
 *
 * @tag: #abstract #backend #parent #controller
 */
abstract class BackendCrudController extends BackendController
{
    use CrudTrait;
}