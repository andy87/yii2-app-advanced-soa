<?php

namespace yii2\console\queryStorages\items;

use yii2\common\models\sources\User;

/**
 * < Console > `UserQueryStorage`
 *
 * @package yii2\console\queryStorages\items
 *
 * @tag #queryStorage #user
 */
class UserQueryStorage extends \yii2\common\queryStorages\items\UserQueryStorage
{
    public const MODEL = User::class;
}