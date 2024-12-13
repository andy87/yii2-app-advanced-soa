<?php

namespace yii2\backend\repositories\items;

use yii2\backend\models\items\User;

/**
 * < Backend > `UserRepository`
 *
 * @package yii2\backend\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \yii2\common\repositories\items\UserRepository
{
    public const MODEL = User::class;
}