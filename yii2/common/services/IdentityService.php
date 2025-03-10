<?php declare(strict_types=1);

namespace yii2\common\services;

use Exception;
use yii\db\ActiveRecord;
use yii2\common\models\Identity;
use yii2\common\models\sources\User;
use yii2\frontend\models\forms\SignupForm;
use yii2\common\components\core\BaseProduces;
use yii2\frontend\producers\IdentityProducer;
use yii2\common\components\core\BaseRepository;
use yii2\common\repositories\IdentityRepository;
use yii2\common\components\services\ActiveRecordService;

/**
 * < Common > `IdentityService`
 *
 * @package yii2\common\services
 *
 * @property-read IdentityRepository $repository;
 *
 * @method Identity getClassModel()
 * @method Identity createModel(array $attributes = [])
 * @method Identity addModel(array $attributes = [])
 *
 * @tag #common #service #identity
 */
class IdentityService extends ActiveRecordService
{
    public ActiveRecord|string $modelClass = Identity::class;
    protected BaseRepository|string|null $repositoryClass = IdentityRepository::class;
    protected BaseProduces|string|null $producerClass = IdentityProducer::class;



    /**
     * @param SignupForm $signupForm
     *
     * @return ?Identity
     *
     * @throws Exception
     *
     * @tag #service #identity #create
     */
    public function signUp( SignupForm $signupForm ): ?Identity
    {
        $identity = null;

        if ( $signupForm->validate() )
        {
            $identity = $this->createModel([
                User::ATTR_USERNAME => $signupForm->username,
                User::ATTR_EMAIL => $signupForm->email,
            ]);
            $identity->setPassword($signupForm->password);
            $identity->generateAuthKey();
            $identity->generateEmailVerificationToken();

            $identity->save();
        }

        return $identity;
    }

    /**
     * @param string $email
     *
     * @return ?Identity
     *
     * @tag #service #identity #find #active #user
     */
    public function findActiveByEmail(string $email): ?Identity
    {
        return $this->repository->findActiveByEmail($email);
    }

    /**
     * @param string $email
     *
     * @return ?Identity
     *
     * @tag #service #identity #find #inactive #user
     */
    public function findResendVerificationUser(string $email): ?Identity
    {
        return $this->repository->findInactiveByEmail($email);
    }

    /**
     * @param string $token
     *
     * @return ?Identity
     *
     * @tag #service #identity #find #verification #token
     */
    public function findInactiveByVerificationToken(string $token): ?Identity
    {
        return $this->repository->findInactiveByVerificationToken($token);
    }

    /**
     * @param ?string $username
     *
     * @return ?Identity
     *
     * @tag #service #identity #find #reset #token
     */
    public function findActiveByUsername(?string $username): ?Identity
    {
        return $this->repository->findActiveByUsername($username);
    }

    /**
     * @param string $password_reset_token
     *
     * @return ?Identity
     *
     * @tag #service #identity #find #reset #token
     */
    public function findIdentityByPasswordResetToken(string $password_reset_token): ?Identity
    {
        return $this->repository->findIdentityByPasswordResetToken($password_reset_token);
    }

    /**
     * @param string $token
     *
     * @return ?Identity
     *
     * @tag #service #identity #find #reset #token
     */
    public function findByPasswordResetToken(string $token): ?Identity
    {
        return $this->repository->findByPasswordResetToken($token);
    }
}