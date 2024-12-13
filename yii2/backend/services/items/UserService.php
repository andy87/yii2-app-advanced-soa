<?php

namespace yii2\backend\services\items;

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
class UserService extends \yii2\common\services\items\UserService
{
    public const CLASS_MODEL = User::class;
}