<?php

namespace app\common\components\core;

use yii\base\BaseObject;

/**
 * Class `BaseResources`
 *
 * @package app\common\components\core
 */
abstract class BaseResources extends BaseObject
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