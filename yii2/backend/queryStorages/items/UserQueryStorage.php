<?php

namespace yii2\backend\queryStorages\items;

use yii2\backend\models\items\User;

/**
 * < Backend > `UserQueryStorage`
 *
 * @package yii2\backend\queryStorages\items
 *
 * @tag #queryStorage #user
 */
class UserQueryStorage extends \yii2\common\queryStorages\items\UserQueryStorage
{
    public const MODEL = User::class;
}
