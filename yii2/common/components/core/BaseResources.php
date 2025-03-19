<?php declare(strict_types=1);

namespace yii2\common\components\core;

use yii2\common\components\interfaces\core\ResourceInterface;

/**
 * < Common > `BaseResources`
 *
 * @package yii2\common\components\core
 */
abstract class BaseResources implements ResourceInterface
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