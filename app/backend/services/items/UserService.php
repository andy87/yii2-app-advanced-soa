<?php

namespace app\backend\services\items;

use app\backend\models\items\User;

/**
 * < Backend > `UserService`
 *
 * @package app\backend\services
 *
 * @tag #backend #service #user
 *
 * @method User|string getClassModel()
 * @method User createModel(array $attributes = [])
 * @method User addModel(array $attributes = [])
 */
class UserService extends \app\common\services\items\UserService
{
    public const CLASS_MODEL = User::class;
}