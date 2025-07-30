<?php

namespace yii2\common\queryStorages\items;

use yii2\common\models\sources\User;
use yii2\common\components\core\BaseQueryStorage;

/**
 * < Common > `UserQueryStorage`
 *
 * @package yii2\common\repositories\items
 *
 * @tag #queryStorage #user
 */
class UserQueryStorage extends BaseQueryStorage
{
    public const MODEL = User::class;

}