<?php

namespace app\common\repositories\items;

use app\common\models\sources\User;
use app\common\components\repositories\MySqlRepository;

/**
 * < Common > `UserRepository`
 *
 * @package app\common\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends MySqlRepository
{
    public const MODEL = User::class;

}