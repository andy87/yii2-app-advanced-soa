<?php declare(strict_types=1);

namespace common\repository;

use Exception;
use yii\db\Query;
use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\repository\items\source\SourceRepository;
use yii2\common\models\Identity;
use yii2\common\models\sources\User;

/**
 * < Common > `IdentityRepository`
 *
 * @package yii2\common\repositories
 *
 * @tag #repositories #identity
 */
class IdentityRepository extends SourceRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = Identity::class;


    /**
     * @param string $email
     *
     * @return Query
     *
     * @tag #repository #identity #find
     *
     * @throws Exception
     */
    public function findActiveByEmail(string $email): Query
    {
        return $this
            ->findModel([
                User::ATTR_EMAIL => $email,
                User::ATTR_STATUS => Identity::STATUS_ACTIVE,
            ]);
    }

    /**
     * @param string $email
     *
     * @return Query
     *
     * @throws Exception
     *
     * @tag #repository #identity #find
     */
    public function findInactiveByEmail(string $email): Query
    {
        return $this
            ->findModel([
                User::ATTR_EMAIL => $email,
                User::ATTR_STATUS => Identity::STATUS_INACTIVE,
            ]);
    }

    /**
     * @param string $token
     *
     * @return Query
     *
     * @throws Exception
     *
     * @tag #repository #identity #find
     */
    public function findInactiveByVerificationToken(string $token): Query
    {
        return $this
            ->findModel([
                User::ATTR_VERIFICATION => $token,
                User::ATTR_STATUS => Identity::STATUS_INACTIVE,
            ]);
    }

    /**
     * @param ?string $username
     *
     * @return Query
     *
     * @throws Exception
     *
     * @tag #repository #identity #find
     */
    public function findActiveByUsername(?string $username): Query
    {
        return $this
            ->findModel([
                User::ATTR_USERNAME => $username,
                User::ATTR_STATUS => Identity::STATUS_ACTIVE,
            ]);
    }

    /**
     * @param string $password_reset_token
     *
     * @return Query
     *
     * @throws Exception
     *
     * @tag #repository #identity #find
     */
    public function findIdentityByPasswordResetToken(string $password_reset_token): Query
    {
        return $this
            ->findModel([
                User::ATTR_PASSWORD_RESET => $password_reset_token,
            ]);
    }

    /**
     * @param string $token
     *
     * @return Query
     *
     * @throws Exception
     *
     * @tag #repository #identity #find
     */
    public function findByPasswordResetToken(string $token): Query
    {
        return $this
            ->findModel([
                User::ATTR_PASSWORD_RESET => $token,
            ]);
    }
}