<?php declare(strict_types=1);

namespace app\common\services\items;

use app\common\{ models\sources\User, components\services\ModelService };

/**
 * < Items > `UserService`
 *
 * @package app\common\services\items
 *
 * @method User|string getClassModel()
 * @method User createModel(array $attributes = [])
 * @method User addModel(array $attributes = [])
 *
 * @tag #common #service #items #user
 */
class UserService extends ModelService
{
    public const CLASS_MODEL = User::class;
}