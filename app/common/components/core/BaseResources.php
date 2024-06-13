<?php

namespace app\common\components\core;

/**
 * Class `BaseResources`
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