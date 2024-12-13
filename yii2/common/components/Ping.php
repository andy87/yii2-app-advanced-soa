<?php

namespace yii2\common\components;

/**
 * Class Ping
 *
 * @package yii2\common\components
 */
class Ping
{
    public const ANSWER = 'pong';

    /**
     * @return string
     */
    public function run(): string
    {
        return self::ANSWER;
    }
}