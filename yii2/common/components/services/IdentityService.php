<?php declare(strict_types=1);

namespace yii2\common\components\services;

use Yii;
use Exception;
use yii2\common\models\Identity;
use yii\base\InvalidConfigException;
use yii2\frontend\models\forms\SignupForm;
use yii2\common\components\system\Manager;
use yii2\common\components\repository\IdentityRepository;
use yii2\common\components\base\producers\IdentityProducer;
use yii2\common\components\base\services\items\source\SourceToolKit;

/**
 * < Common > `IdentityService`
 *
 * @property IdentityRepository $_repository
 * @property IdentityProducer $_producer
 *
 * @package yii2\common\services
 *
 * @tag #common #service #identity
 */
class IdentityService extends SourceToolKit
{
    /**
     * @return void
     *
     * @throws InvalidConfigException
     *
     * @tag #service #identity #init
     */
    public function init(): void
    {
        $this->setupRequire();
    }

    /**
     * @throws InvalidConfigException
     */
    private function setupRequire(): void
    {
        $this->setupRepository();
        $this->setupProducer();
    }

    /**
     * @throws InvalidConfigException
     */
    private function setupRepository(): void
    {
        /** @var IdentityRepository $repository */
        $repository = Yii::createObject([
            'class' => IdentityRepository::class
        ]);

        $this->_repository = $repository;
    }

    /**
     * @throws InvalidConfigException
     */
    private function setupProducer(): void
    {
        /** @var IdentityProducer $producer */
        $producer = Yii::createObject([ IdentityProducer::class],[
            Yii::createObject([
                'class' => Manager::class,
                'modelClass' => Identity::class
            ])
        ]);

        $this->_producer = $producer;
    }



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
            $identity = $this->_producer->createBySignUpForm( $signupForm );
        }

        return $identity;
    }

    /**
     * @param string $email
     *
     * @return ?Identity
     *
     * @throws Exception
     *
     * @tag #service #identity #find #active #user
     */
    public function findActiveByEmail(string $email): ?Identity
    {
        $query = $this->_repository->findActiveByEmail($email);

        /** @var ?Identity $identity */
        $identity = $query->one();

        return $identity;
    }

    /**
     * @param string $email
     *
     * @return ?Identity
     *
     * @throws Exception
     *
     * @tag #service #identity #find #inactive #user
     */
    public function findResendVerificationUser(string $email): ?Identity
    {
        $query = $this->_repository->findInactiveByEmail($email);

        /** @var Identity $identity */
        $identity = $query->one();

        return $identity;
    }

    /**
     * @param string $token
     *
     * @return ?Identity
     *
     * @throws Exception
     *
     * @tag #service #identity #find #verification #token
     */
    public function findInactiveByVerificationToken(string $token): ?Identity
    {
        $query = $this->_repository->findInactiveByVerificationToken($token);

        /** @var Identity $identity */
        $identity = $query->one();

        return $identity;
    }

    /**
     * @param ?string $username
     *
     * @return ?Identity
     *
     * @throws Exception
     *
     * @tag #service #identity #find #reset #token
     */
    public function findActiveByUsername(?string $username): ?Identity
    {
        $query = $this->_repository->findActiveByUsername($username);

        /** @var Identity $identity */
        $identity = $query->one();

        return $identity;
    }

    /**
     * @param string $password_reset_token
     *
     * @return ?Identity
     *
     * @throws Exception
     *
     * @tag #service #identity #find #reset #token
     */
    public function findIdentityByPasswordResetToken(string $password_reset_token): ?Identity
    {
        $query = $this->_repository->findIdentityByPasswordResetToken($password_reset_token);

        /** @var Identity $identity */
        $identity = $query->one();

        return $identity;
    }

    /**
     * @param string $token
     *
     * @return ?Identity
     *
     * @throws Exception
     *
     * @tag #service #identity #find #reset #token
     */
    public function findByPasswordResetToken(string $token): ?Identity
    {
        $query = $this->_repository->findByPasswordResetToken($token);

        /** @var Identity $identity */
        $identity = $query->one();

        return $identity;
    }

}