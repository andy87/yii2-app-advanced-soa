<?php declare(strict_types=1);

namespace yii2\frontend\components\controllers\parents;

use yii2\common\components\traits\controllers\ActionTrait;
use yii2\common\components\traits\handlers\FrontendHandler;

/**
 * < Frontend > Родительский класс для контроллеров в окружении: `frontend`
 *
 * @property FrontendHandler $handler
 * @property array $resources
 *
 * @package app\frontend\components\controllers\parents
 *
 * @tag: #abstract #frontend #parent #controller
 */
abstract class FrontendCrudController extends FrontendController
{
    use ActionTrait;
}