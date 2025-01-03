<?php declare(strict_types=1);

namespace common\interfaces\services;

use common\interfaces\CatcherInterface;

/**
 * < Common >
 *
 * @package yii2\common\components\interfaces\services\core
 *
 * @tag: #abstract #common #interface #service #logger
 */
interface ServiceLoggerInterface
{
    /**
     * @return \common\interfaces\CatcherInterface|string
     */
    public function getLoggerClass(): CatcherInterface|string;

    /**
     * @return CatcherInterface
     */
    public function getLogger(): CatcherInterface;
}