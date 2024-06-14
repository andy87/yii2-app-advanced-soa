<?php

namespace app\frontend\repositories;

use app\frontend\models\items\User;
use app\common\components\repositories\MySqlRepository;

/**
 * Class `UserRepository`
 *
 * @package app\frontend\repositories
 */
class UserRepository extends MySqlRepository
{
    /** @var string */
    public const MODEL = User::class;



    /**
     * @param string $email
     *
     * @return ?User
     */
    public function findActiveByEmail(string $email): ?User
    {
        $query = $this
            ->findByCriteria([
                'status' => \app\common\models\User::STATUS_ACTIVE,
                'email' => $email,
            ]);

        /** @var ?User $user */
        $user = $query->one();

        return $user;
    }
}