<?php declare(strict_types=1);

namespace yii2\common\components\base\controllers\items;

use yii2\common\components\base\handlers\items\source\SourceHandler;
use yii2\common\components\interfaces\controllers\ControllerHandlerInterface;

/**
 * < Common > Родительский класс для всех контроллеров с сервисом
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #items #web #handler
 */
abstract class BaseWebHandlerController extends BaseWebController implements ControllerHandlerInterface
{
    /** @var SourceHandler `Обработчик` */
    protected SourceHandler $handler;

    /** @var array $resources */
    protected array $resources = [];
}