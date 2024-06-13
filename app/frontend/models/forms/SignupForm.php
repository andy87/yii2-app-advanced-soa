<?php

namespace app\frontend\models\forms;

use app\common\models\User;
use app\frontend\services\controllers\AuthService;
use Yii;
use yii\base\Model;
use yii\db\Exception;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public const MESSAGE_SUCCESS = 'Благодарим за регистрацию. Пожалуйста, проверьте свой почтовый ящик.';
    public const MESSAGE_ERROR = 'Ошибка регистрации. Пожалуйста, попробуйте еще раз.';

    public const ATTR_USERNAME = 'username';
    public const ATTR_EMAIL = 'email';
    public const ATTR_PASSWORD = 'password';


    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[self::ATTR_USERNAME, self::ATTR_EMAIL], 'trim'],
            [[self::ATTR_USERNAME, self::ATTR_EMAIL, self::ATTR_PASSWORD], 'required'],
            [self::ATTR_USERNAME, 'string', 'min' => 2, 'max' => 255],

            [self::ATTR_EMAIL, 'email'],
            [self::ATTR_EMAIL, 'string', 'max' => 255],

            [self::ATTR_PASSWORD, 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            [self::ATTR_EMAIL, 'unique', 'targetClass' => '\app\common\models\User', 'message' => 'This email address has already been taken.'],
            [self::ATTR_USERNAME, 'unique', 'targetClass' => '\app\common\models\User', 'message' => 'This username has already been taken.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return ?bool whether the creating new account was successful and email was sent
     *
     * @throws Exception
     */
    public function signup(): ?bool
    {
        if (!$this->validate()) {
            return null;
        }
        
        AuthService::getInstance()->handlerSignupForm($this, Yii::$app->request->post());

        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail(User $user): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
