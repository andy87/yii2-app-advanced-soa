<?php

namespace app\frontend\services\items;

use app\frontend\models\items\User;

/**
 * < Frontend > `UserService`
 *
 * @package app\frontend\services\items
 *
 * @tag #frontend #service #user
 *
 * @method User|string getClassModel()
 * @method User createModel(array $attributes = [])
 * @method User addModel(array $attributes = [])
 */
class UserService extends \app\common\services\items\UserService
{
    public const CLASS_MODEL = User::class;
}