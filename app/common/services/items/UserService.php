<?php declare(strict_types=1);

namespace app\common\services\items;

use app\common\{models\sources\User,
    components\services\ModelService,
    repositories\items\UserRepository,
    repositories\items\UserRepositoryClickHouse};

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

    private UserRepository $repository;

    public function init()
    {
        parent::init();

        $this->repository = new UserRepository();
    }

    /**
     * @example
     * ```php
     *  (new UserService)->getOnLastMonth();
     * ```
     * @return array
     */
    public function getOnLastMonth(): array
    {
        $from = date('Y-m-d', strtotime('first day of last month'));
        $to = date('Y-m-d', strtotime('last day of last month'));

        return $this->getByPeriod($from, $to);
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return array
     */
    public function getByPeriod( string $from, string $to ): array
    {
        $query = $this
            ->repository
            ->findByPeriod($from, $to);

        return $query->all();
    }
}