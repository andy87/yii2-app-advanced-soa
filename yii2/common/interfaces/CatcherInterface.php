<?php declare(strict_types=1);

namespace common\interfaces;

use Exception;

/**
 * < Common >
 *
 * @package yii2\common\components\interfaces
 *
 * @tag: #abstract #common #interface #catcher
 */
interface CatcherInterface
{
    /**
     * @param Exception $exception
     * @param ?string $method
     * @param ?string $message
     * @param ?array $data
     *
     * @return bool
     */
    public static function catchHandler(Exception $exception, ?string $method, ?string $message, ?array $data = []): bool;
}