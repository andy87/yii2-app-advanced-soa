<?php declare(strict_types=1);

namespace common\services\items;


use common\repository\items\UserRepository;
use Yii;
use yii\base\InvalidConfigException;
use common\components\base\services\items\SingletonService;
use commonmodels\sources\User;

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

    /** @var \common\repository\items\UserRepository $repository */
    private \common\repository\items\UserRepository $repository;



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
     * @return \common\repository\items\UserRepository
     *
     * @throws InvalidConfigException
     */
    private function getRepository(): UserRepository
    {
        /** @var \common\repository\items\UserRepository $repository */
        $repository = Yii::createObject([ 'class' => \common\repository\items\UserRepository::class],[
            static::CLASS_MODEL, static::CLASS_MODEL
        ]);

        return $repository;
    }

}