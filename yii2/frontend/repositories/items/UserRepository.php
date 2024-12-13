<?php

namespace yii2\frontend\repositories\items;

use yii2\frontend\models\items\User;

/**
 * < Frontend > `UserRepository`
 *
 * @package yii2\frontend\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \yii2\common\repositories\items\UserRepository
{
    public const MODEL = User::class;
}