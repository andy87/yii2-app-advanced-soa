<?php declare(strict_types=1);

namespace app\common\components\base\controllers\items;

use app\common\components\traits\handlers\HasHandler;
use app\console\components\handlers\parents\ConsoleHandler;
use app\common\components\base\controllers\BaseConsoleController;

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @property ConsoleHandler $handler
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #items #console
 */
abstract class BaseConsoleHandlerController extends BaseConsoleController
{
    use HasHandler;
}