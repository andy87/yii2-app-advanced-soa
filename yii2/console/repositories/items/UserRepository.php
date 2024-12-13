<?php

namespace yii2\console\repositories\items;

use yii2\common\models\sources\User;

/**
 * < Console > `UserRepository`
 *
 * @package yii2\console\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \yii2\common\repositories\items\UserRepository
{
    public const MODEL = User::class;
}