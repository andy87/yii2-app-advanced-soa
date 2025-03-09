<?php

namespace yii2\console\services\db;

use yii\db\ActiveRecord;
use yii2\console\models\items\User;
use yii2\common\services\db\UserService;

/**
 * < Console > `UserServices`
 *
 * @package yii2\console\services
 *
 * @tag #services #user
 */
class UserServices extends UserService
{
    /** @var ActiveRecord|string  */
    protected ActiveRecord|string $modelClass = User::class;
}