<?php declare(strict_types=1);

namespace common\components\base\controllers\items;

use common\components\traits\has\HasHandlerTrait;
use common\components\traits\handlers\ConsoleHandler;
use common\components\base\controllers\BaseConsoleController;
use common\components\base\handlers\items\settings\HandlerSettings;

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @property ConsoleHandler $handler
 *
 * @package yii2\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #items #console
 */
abstract class BaseConsoleHandlerController extends BaseConsoleController
{
    use HasHandlerTrait;



    /** @var array */
    public array $serviceSettings = [];



    /**
     * @return HandlerSettings
     */
    public function getHandlerSettings(): HandlerSettings
    {
        return new HandlerSettings( ...$this->serviceSettings );
    }
}