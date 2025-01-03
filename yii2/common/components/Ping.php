<?php

namespace common\components;

/**
 * Class Ping
 *
 * @package yii2\common\components
 */
class Ping
{
    public const string ANSWER = 'pong';

    /**
     * @return string
     */
    public function run(): string
    {
        return self::ANSWER;
    }
}