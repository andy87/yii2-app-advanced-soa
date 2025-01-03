<?php

namespace console\repository\items;

use yii2\common\models\sources\User;

/**
 * < Console > `UserRepository`
 *
 * @package yii2\console\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \common\repository\items\UserRepository
{
    public const MODEL = User::class;
}