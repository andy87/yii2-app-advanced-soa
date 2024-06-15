<?php declare(strict_types=1);

namespace app\common\components\core;

/**
 * < Common > `BaseResources`
 *
 * @package app\common\components\core
 */
abstract class BaseResources
{
    public const KEY = 'R';

    /**
     * @return static[]
     */
    public function release(): array
    {
        return [self::KEY => $this];
    }
}