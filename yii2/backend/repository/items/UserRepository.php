<?php

namespace backend\repository\items;

use yii2\backend\models\items\User;

/**
 * < Backend > `UserRepository`
 *
 * @package yii2\backend\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \common\repository\items\UserRepository
{
    public const User|string MODEL = User::class;
}