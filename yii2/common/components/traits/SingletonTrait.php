<?php

namespace yii2\common\components\traits;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Trait Singleton
 *
 * @package yii2\common\components\traits
 *
 * @tag #common #trait #singleton
 */
trait SingletonTrait
{
    /** @var object */
    public static object $instance;



    /**
     * @param array $params
     *
     * @return static
     *
     * @throws InvalidConfigException
     */
    public static function getInstance( array $params = [] ): static
    {
        if (!isset(self::$instance)) {

            $classConfig = array_merge($params,[
                'class' => static::class
            ]);

            /** @var static $instance */
            $instance = Yii::createObject($classConfig);

            self::$instance = $instance;
        }

        return self::$instance;
    }
}