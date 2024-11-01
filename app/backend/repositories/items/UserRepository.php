<?php

namespace app\backend\repositories\items;

use app\backend\models\items\User;

/**
 * < Backend > `UserRepository`
 *
 * @package app\backend\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \app\common\repositories\items\UserRepository
{
    public const MODEL = User::class;
}