<?php

namespace app\backend\services\items;

use app\backend\models\items\User;

/**
 * < Backend > `UserService`
 *
 * @package app\backend\services
 *
 * @method User|string getClassModel()
 * @method User createModel(array $attributes = [])
 * @method User addModel(array $attributes = [])
 *
 * @tag #backend #service #user
 */
class UserService extends \app\common\services\items\UserService
{
    public const CLASS_MODEL = User::class;
}