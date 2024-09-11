<?php

namespace app\frontend\repositories\items;

use app\frontend\models\items\User;

/**
 * < Frontend > `UserRepository`
 *
 * @package app\frontend\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \app\common\repositories\items\UserRepository
{
    public const MODEL = User::class;
}