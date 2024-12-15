<?php declare(strict_types=1);

namespace yii2\common\components\core;

use Yii;
use yii\base\{ BaseObject, InvalidConfigException };

/**
 * < Common > `BaseSingleton`
 *
 * @package yii2\common\components
 */
abstract class BaseSingleton extends BaseObject
{
    /** @var array  */
    public const CONFIG = [];

    /**
     * @return static
     *
     * @throws InvalidConfigException
     *
     * @tag #core #singleton
     */
    public static function getInstance(): static
    {
        /** @var static $object */
        $object = Yii::createObject(static::getConfig());

        return $object;
    }

    /**
     * @return array
     *
     * @tag #core #singleton
     */
    public static function getConfig(): array
    {
        return array_merge(static::CONFIG, ['class' => static::class]);
    }
}