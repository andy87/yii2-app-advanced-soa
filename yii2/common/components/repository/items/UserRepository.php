<?php

namespace yii2\common\components\repository\items;

use yii2\common\components\base\repository\MySqlRepository;
use yii2\common\models\sources\User;

/**
 * < Common > `UserRepository`
 *
 * @package yii2\common\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends MySqlRepository
{
    public const MODEL = User::class;

}