<?php declare(strict_types=1);

namespace yii2\common\components\interfaces\services\base;

use yii2\common\components\interfaces\CatcherInterface;

/**
 * < Common >
 *
 * @package app\common\components\interfaces\services\core
 *
 * @tag: #abstract #common #interface #service #logger
 */
interface ServiceLoggerInterface
{
    /**
     * @return CatcherInterface|string
     */
    public function getLoggerClass(): CatcherInterface|string;

    /**
     * @return CatcherInterface
     */
    public function getLogger(): CatcherInterface;
}