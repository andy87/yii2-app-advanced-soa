<?php declare(strict_types=1);

namespace yii2\common\components\services\items;


use yii2\common\models\sources\User;
use yii2\common\components\repository\items\UserRepository;
use yii2\common\components\base\services\items\SingletonService;

/**
 * < Items > `UserService`
 *
 * @package yii2\common\services\items
 *
 * @method User|string getClassModel()
 * @method User createModel(array $attributes = [])
 * @method User addModel(array $attributes = [])
 *
 * @tag #common #service #items #user
 */
class UserService extends SingletonService
{
    public const CLASS_MODEL = User::class;

    private UserRepository $repository;

    /**
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->repository = new UserRepository(static::CLASS_MODEL, static::CLASS_MODEL );
    }

}