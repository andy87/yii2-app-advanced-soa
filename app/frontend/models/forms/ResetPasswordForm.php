<?php

namespace app\frontend\models\forms;

use Yii;
use app\common\models\User;
use yii\base\{ Model, InvalidArgumentException };

/**
 * Class `ResetPasswordForm`
 *
 * @package app\frontend\models\forms
 */
class ResetPasswordForm extends Model
{
    public const ATTR_PASSWORD = 'password';

    public const MESSAGE_SUCCESS = 'Новый пароль был сохранен';
    public const MESSAGE_ERROR = 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.';

    public ?string $password = null;

    /**
     * @var User
     */
    public User $user;



    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     *
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct( string $token, array $config = [])
    {
        if ( strlen($token) )
        {
            if ($this->user = User::findByPasswordResetToken($token))
            {
                parent::__construct($config);

            } else {

                throw new InvalidArgumentException('Wrong password reset token.');
            }
        }

        throw new InvalidArgumentException('Password reset token cannot be blank.');
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [self::ATTR_PASSWORD, 'required'],
            [self::ATTR_PASSWORD, 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }
}
