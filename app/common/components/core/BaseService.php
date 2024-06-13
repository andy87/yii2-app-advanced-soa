<?php

namespace app\common\components\core;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Class `BaseService`
 *
 * @package app\common\components\core
 */
abstract class BaseService
{
    /**
     * @return static
     *
     * @throws InvalidConfigException
     */
    public static function getInstance(): static
    {
        /** @var static $object */
        $object = Yii::createObject(static::getConfig());

        return $object;
    }

    /**
     * @return array
     */
    public static function getConfig(): array
    {
        return ['class' => static::class];
    }
}