<?php

namespace app\common\components;

/**
 * Class Ping
 *
 * @package app\common\components
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