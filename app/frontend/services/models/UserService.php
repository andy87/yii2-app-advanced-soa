<?php

namespace app\frontend\services\models;

use app\common\components\services\ModelService;
use app\frontend\models\forms\SignupForm;
use app\frontend\models\items\User;
use yii\db\Exception;

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

    /**
     * Signs user up.
     *
     * @param SignupForm $signupForm
     *
     * @return \app\common\models\User
     *
     * @throws Exception
     */
    public function signup(SignupForm $signupForm ): \app\common\models\User
    {
        $user = new \app\common\models\User();

        $user->username = $signupForm->username;
        $user->email = $signupForm->email;
        $user->setPassword($signupForm->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        $user->save();

        return $user;
    }
}