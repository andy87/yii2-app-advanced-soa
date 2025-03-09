<?php

namespace yii2\frontend\services\db;

use yii\db\ActiveRecord;
use yii2\frontend\models\items\User;

/**
 * < Frontend > `UserService`
 *
 * @package yii2\frontend\services\items
 *
 * @tag #frontend #service #user
 *
 * @method User|string getClassModel()
 * @method User createModel(array $attributes = [])
 * @method User addModel(array $attributes = [])
 */
class UserService extends \yii2\common\services\db\UserService
{
    /** @var ActiveRecord|string  */
    protected ActiveRecord|string $modelClass = User::class;
}