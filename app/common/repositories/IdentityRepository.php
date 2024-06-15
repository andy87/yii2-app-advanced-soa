<?php declare(strict_types=1);

namespace app\common\repositories;

use app\common\models\Identity;
use app\common\components\repositories\MySqlRepository;

/**
 * < Common > `IdentityRepository`
 *
 * @package app\frontend\repositories
 *
 * @tag #repositories #identity
 */
class IdentityRepository extends MySqlRepository
{
    /** @var string */
    public const MODEL = Identity::class;



    /**
     * @param string $email
     *
     * @return ?Identity
     *
     * @tag #repository #identity #find
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
     *
     * @tag #repository #identity #find
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
     *
     * @tag #repository #identity #find
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

    /**
     * @param ?string $username
     *
     * @return ?Identity
     *
     * @tag #repository #identity #find
     */
    public function findByUsername(?string $username): ?Identity
    {
        $query = $this
            ->findByCriteria([
                'username' => $username,
            ]);

        /** @var ?Identity $identity */
        $identity = $query->one();

        return $identity;
    }
}