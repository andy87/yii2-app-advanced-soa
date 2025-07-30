<?php

namespace yii2\frontend\queryStorages\items;

use yii2\frontend\models\items\User;

/**
 * < Frontend > `UserQueryStorage`
 *
 * @package yii2\frontend\queryStorages\items
 *
 * @tag #queryStorage #user
 */
class UserQueryStorage extends \yii2\common\queryStorages\items\UserQueryStorage
{
    public const MODEL = User::class;
}