<?php

namespace yii2\backend\components\repository\items;

use yii2\backend\models\items\User;

/**
 * < Backend > `UserRepository`
 *
 * @package yii2\backend\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends \yii2\common\components\repository\items\UserRepository
{
    public const MODEL = User::class;
}