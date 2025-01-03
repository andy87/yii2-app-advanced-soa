<?php

namespace frontend\repository\items;

use yii2\frontend\models\items\User;

/**
 * < Frontend > `UserRepository`
 *
 * @package yii2\frontend\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \common\repository\items\UserRepository
{
    public const User|string MODEL = User::class;
}