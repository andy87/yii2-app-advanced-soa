<?php declare(strict_types=1);

namespace app\common\repositories;

use app\common\models\Identity;
use app\common\models\sources\User;
use app\common\components\repositories\MySqlRepository;

/**
 * < Common > `IdentityRepository`
 *
 * @package app\common\repositories
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
                User::ATTR_EMAIL => $email,
                User::ATTR_STATUS => Identity::STATUS_ACTIVE,
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
                User::ATTR_EMAIL => $email,
                User::ATTR_STATUS => Identity::STATUS_INACTIVE,
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
    public function findInactiveByVerificationToken(string $token): ?Identity
    {
        $query = $this
            ->findByCriteria([
                User::ATTR_VERIFICATION => $token,
                User::ATTR_STATUS => Identity::STATUS_INACTIVE,
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
    public function findActiveByUsername(?string $username): ?Identity
    {
        $query = $this
            ->findByCriteria([
                User::ATTR_USERNAME => $username,
                User::ATTR_STATUS => Identity::STATUS_ACTIVE,
            ]);

        /** @var ?Identity $identity */
        $identity = $query->one();

        return $identity;
    }

    /**
     * @param string $password_reset_token
     *
     * @return ?Identity
     *
     * @tag #repository #identity #find
     */
    public function findIdentityByPasswordResetToken(string $password_reset_token): ?Identity
    {
        $query = $this
            ->findByCriteria([
                User::ATTR_PASSWORD_RESET => $password_reset_token,
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
    public function findByPasswordResetToken(string $token): ?Identity
    {
        $query = $this
            ->findByCriteria([
                User::ATTR_PASSWORD_RESET => $token,
            ]);

        /** @var ?Identity $identity */
        $identity = $query->one();

        return $identity;
    }
}