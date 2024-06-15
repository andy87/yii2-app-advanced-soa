<?php declare(strict_types=1);

namespace app\common\services;

use app\common\models\Identity;
use app\common\components\services\ModelService;
use app\frontend\repositories\IdentityRepository;
use yii\base\InvalidConfigException;

/**
 * < Common > `IdentityService`
 *
 * @package app\common\services
 *
 * @tag #common #service #identity
 */
class IdentityService extends ModelService
{
    public const CLASS_MODEL = Identity::class;


    /** @var IdentityRepository $identityRepository */
    public IdentityRepository $identityRepository;


    /**
     * @return void
     *
     * @throws InvalidConfigException
     *
     * @tag #service #identity #init
     */
    public function init(): void
    {
        $this->identityRepository = IdentityRepository::getInstance();
    }

    /**
     * @param SignupForm $signupForm
     *
     * @return Identity
     *
     * @throws Exception
     *
     * @tag #service #identity #create
     */
    public function createItem(SignupForm $signupForm): Identity
    {
        $identity = $this->createModel();
        $identity->setAttribute($identity::ATTR_USERNAME, $signupForm->username);
        $identity->setAttribute($identity::ATTR_EMAIL, $signupForm->email);
        $identity->setPassword($signupForm->password);
        $identity->generateAuthKey();
        $identity->generateEmailVerificationToken();

        $identity->save();

        return $identity;
    }

    /**
     * @param string $email
     *
     * @return ?Identity
     *
     * @tag #service #identity #find #active #user
     */
    public function findActiveUserByEmail(string $email): ?Identity
    {
        return $this
            ->identityRepository
            ->findActiveByEmail($email);
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
        return $this
            ->identityRepository
            ->findInactiveByEmail($email);
    }

    /**
     * @param string $token
     *
     * @return ?Identity
     *
     * @tag #service #identity #find #verification #token
     */
    public function findByVerificationToken(string $token): ?Identity
    {
        return $this
            ->identityRepository
            ->findByVerificationToken($token);
    }

    /**
     * @param ?string $username
     *
     * @return ?Identity
     *
     * @tag #service #identity #find #reset #token
     */
    public function findByUsername(?string $username): ?Identity
    {
        return $this
            ->identityRepository
            ->findByUsername($username);
    }
}