<?php

namespace yii2\backend\services\db;

use yii\db\ActiveRecord;
use yii2\backend\models\items\User;

/**
 * < Backend > `UserService`
 *
 * @package yii2\backend\services
 *
 * @method User|string getClassModel()
 * @method User createModel(array $attributes = [])
 * @method User addModel(array $attributes = [])
 *
 * @tag #backend #service #user
 */
class UserService extends \yii2\common\services\db\UserService
{
    /** @var ActiveRecord|string  */
    protected ActiveRecord|string $modelClass = User::class;
}