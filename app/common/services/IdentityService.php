<?php declare(strict_types=1);

namespace app\common\services;

use app\common\models\Identity;
use app\common\components\services\ModelService;
use app\common\repositories\IdentityRepository;
use app\frontend\models\forms\SignupForm;
use Exception;
use yii\base\InvalidConfigException;

/**
 * < Common > `IdentityService`
 *
 * @package app\common\services
 *
 * @tag #common #service #identity
 *
 * @method Identity getClassModel()
 * @method Identity createModel(array $attributes = [])
 * @method Identity addModel(array $attributes = [])
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
     * @return ?Identity
     *
     * @throws Exception
     *
     * @tag #service #identity #create
     */
    public function signUp(SignupForm $signupForm): ?Identity
    {
        $identity = null;

        if ( $signupForm->validate() )
        {
            $identity = $this->createModel();
            $identity->setAttribute($identity::ATTR_USERNAME, $signupForm->username);
            $identity->setAttribute($identity::ATTR_EMAIL, $signupForm->email);
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
        return $this->identityRepository->findActiveByEmail($email);
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
        return $this->identityRepository->findInactiveByEmail($email);
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
        return $this->identityRepository->findByVerificationToken($token);
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
        return $this->identityRepository->findActiveByUsername($username);
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
        return $this->identityRepository->findIdentityByPasswordResetToken($password_reset_token);
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
        return $this->identityRepository->findByPasswordResetToken($token);
    }
}