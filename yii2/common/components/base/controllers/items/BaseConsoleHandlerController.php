<?php declare(strict_types=1);

namespace yii2\common\components\base\controllers\items;

use yii2\common\components\base\controllers\BaseConsoleController;
use yii2\common\components\base\handlers\items\settings\HandlerSettings;
use yii2\common\components\traits\handlers\ConsoleHandler;
use yii2\common\components\traits\handlers\HasHandler;

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @property \yii2\common\components\traits\handlers\ConsoleHandler $handler
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #items #console
 */
abstract class BaseConsoleHandlerController extends BaseConsoleController
{
    use HasHandler;



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