<?php declare(strict_types=1);

namespace common\components\base\controllers;

use yii\helpers\BaseConsole;
use common\components\base\controllers\items\source\SourceConsoleController;

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @package yii2\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #console
 */
abstract class BaseConsoleController extends SourceConsoleController
{
    /** @var string  */
    protected const string MESSAGE_SUCCESS = 'Success!';

    /** @var string  */
    protected const string MESSAGE_ERROR = 'Error!';

    /** @var string  */
    protected const string DATETIME_FORMAT = 'Y-m-d H:i:s';



    /**
     * @param string $__METHOD__
     *
     * @return void
     */
    protected function printConsoleFuncStart(string $__METHOD__ ): void
    {
        echo PHP_EOL;

        $this->printConsole($__METHOD__ . '|Start');
    }

    /**
     * @param string $__METHOD__
     *
     * @return void
     */
    protected function printConsoleFuncEnd(string $__METHOD__ ): void
    {
        $this->printConsole($__METHOD__ . '|Finish' . PHP_EOL);
    }

    /**
     * @param string $message
     * @param int $color
     *
     * @return void
     */
    protected function printConsole(string $message, int $color = BaseConsole::FG_GREY ): void
    {
        $message = date(static::DATETIME_FORMAT) . ' | ' . $message . PHP_EOL;

        $this->stdout( $message, $color );
    }

    /**
     * @param ?string $message
     *
     * @return void
     */
    protected function printConsoleSuccess(?string $message = null ): void
    {
        $this->stdout(static::MESSAGE_SUCCESS , BaseConsole::FG_GREEN );

        if( $message ) {
            $this->stdout(" $message" . PHP_EOL);
        }
    }

    /**
     * @param ?string $message
     *
     * @return void
     */
    protected function printConsoleError(?string $message = null ): void
    {
        $this->stdout(static::MESSAGE_ERROR  , BaseConsole::FG_RED);

        if( $message ) {
            $this->stdout(" $message" . PHP_EOL);
        }
    }

}