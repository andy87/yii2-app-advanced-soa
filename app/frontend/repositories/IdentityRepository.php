<?php

namespace app\frontend\repositories;

use app\common\models\Identity;
use app\common\components\repositories\MySqlRepository;

/**
 * Class `IdentityRepository`
 *
 * @package app\frontend\repositories
 */
class IdentityRepository extends MySqlRepository
{
    /** @var string */
    public const MODEL = Identity::class;



    /**
     * @param string $email
     *
     * @return ?Identity
     */
    public function findActiveByEmail(string $email): ?Identity
    {
        $query = $this
            ->findByCriteria([
                'email' => $email,
                'status' => Identity::STATUS_ACTIVE,
            ]);

        /** @var ?Identity $identity */
        $identity = $query->one();

        return $identity;
    }

    /**
     * @param string $email
     *
     * @return ?Identity
     */
    public function findInactiveByEmail(string $email): ?Identity
    {
        $query = $this
            ->findByCriteria([
                'email' => $email,
                'status' => Identity::STATUS_INACTIVE,
            ]);

        /** @var ?Identity $identity */
        $identity = $query->one();

        return $identity;
    }

    /**
     * @param string $token
     *
     * @return ?Identity
     */
    public function findByVerificationToken(string $token): ?Identity
    {
        $query = $this
            ->findByCriteria([
                'verification_token' => $token,
                'status' => Identity::STATUS_INACTIVE,
            ]);

        /** @var ?Identity $identity */
        $identity = $query->one();

        return $identity;
    }
}