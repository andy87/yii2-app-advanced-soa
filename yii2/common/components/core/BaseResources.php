<?php declare(strict_types=1);

namespace yii2\common\components\core;

/**
 * < Common > `BaseResources`
 *
 * @package yii2\common\components\core
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