<?php

namespace app\frontend\services\models;

use app\common\models\Identity;
use app\frontend\models\forms\SignupForm;
use app\frontend\repositories\IdentityRepository;
use app\common\components\services\ModelService;
use yii\base\{ Exception, InvalidConfigException };

/**
 * < Frontend > `UserService`
 *
 * @package app\frontend\services\models
 *
 * @method Identity createModel(array $attributes = [])
 * @method Identity addModel(array $attributes = [])
 */
class IdentityService extends ModelService
{
    /** @var string */
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
}