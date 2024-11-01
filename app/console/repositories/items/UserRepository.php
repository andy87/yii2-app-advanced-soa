<?php

namespace app\console\repositories\items;

use app\common\models\sources\User;

/**
 * < Console > `UserRepository`
 *
 * @package app\console\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \app\common\repositories\items\UserRepository
{
    public const MODEL = User::class;
}