<?php declare(strict_types=1);

namespace yii2\backend\components\controllers\parents;

use yii2\common\components\traits\controllers\ActionTrait;
use yii2\common\components\traits\handlers\BackendHandler;

/**
 * < Backend > Родительский класс для контроллеров в окружении: `backend`
 *
 * @property BackendHandler $handler
 * @property array $resources
 *
 * @package app\backend\components\controllers\parents
 *
 * @tag: #abstract #backend #parent #controller
 */
abstract class BackendCrudController extends BackendController
{
    use ActionTrait;
}