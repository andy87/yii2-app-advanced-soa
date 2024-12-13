<?php

namespace yii2\common\repositories\items;

use yii2\common\models\sources\User;
use yii2\common\components\repositories\MySqlRepository;

/**
 * < Common > `UserRepository`
 *
 * @package yii2\common\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends MySqlRepository
{
    public const MODEL = User::class;

}