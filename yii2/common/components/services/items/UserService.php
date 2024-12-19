<?php declare(strict_types=1);

namespace yii2\common\components\services\items;


use Yii;
use yii\base\InvalidConfigException;
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
    /** @var string */
    public const CLASS_MODEL = User::class;

    /** @var UserRepository $repository */
    private UserRepository $repository;



    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        $this->setupRepository();
    }

    /**
     * @throws InvalidConfigException
     */
    private function setupRepository(): void
    {
        $this->repository = $this->getRepository();
    }

    /**
     * @return UserRepository
     *
     * @throws InvalidConfigException
     */
    private function getRepository(): UserRepository
    {
        /** @var UserRepository $repository */
        $repository = Yii::createObject([ 'class' => UserRepository::class],[
            static::CLASS_MODEL, static::CLASS_MODEL
        ]);

        return $repository;
    }

}