<?php

namespace app\frontend\services\models;

use yii\db\Exception;
use yii\base\InvalidConfigException;
use app\frontend\repositories\UserRepository;
use \app\common\models\User as CommonModelsUser;
use app\common\components\services\ModelService;
use app\frontend\models\{ items\User, forms\SignupForm };

/**
 * Class `UserService`
 *
 * @package app\frontend\services\models
 *
 * @method User createModel(array $attributes = [])
 * @method User addModel(array $attributes = [])
 */
class UserService extends ModelService
{
    /** @var string */
    public const CLASS_MODEL = User::class;

    public UserRepository $userRepository;

    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        $this->userRepository = UserRepository::getInstance();
    }

    /**
     * @param SignupForm $signupForm
     *
     * @return CommonModelsUser
     *
     * @throws Exception
     */
    public function signup(SignupForm $signupForm ): CommonModelsUser
    {
        $user = new CommonModelsUser();

        $user->username = $signupForm->username;
        $user->email = $signupForm->email;
        $user->setPassword($signupForm->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        $user->save();

        return $user;
    }

    /**
     * @param string $email
     *
     * @return ?User
     */
    public function getActiveUserByEmail(string $email): ?User
    {
        return $this
            ->userRepository
            ->findActiveByEmail($email);
    }
}