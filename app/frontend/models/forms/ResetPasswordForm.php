<?php

namespace app\frontend\models\forms;

use Yii;
use app\common\models\Identity;
use yii\base\{ Model, InvalidArgumentException };

/**
 * < Frontend > `ResetPasswordForm`
 *
 * @package app\frontend\models\forms
 *
 * @tag #models #forms #reset #password
 */
class ResetPasswordForm extends Model
{
    public const ATTR_PASSWORD = 'password';

    public const MESSAGE_SUCCESS = 'Новый пароль был сохранен';
    public const MESSAGE_ERROR = 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.';

    public ?string $password = null;

    /**
     * @var Identity
     */
    private Identity $_identity;



    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     *
     * @throws InvalidArgumentException if token is empty or not valid
     *
     * @tag #constructor
     */
    public function __construct( string $token, array $config = [])
    {
        if ( strlen($token) )
        {
            if ($this->_identity = Identity::findByPasswordResetToken($token))
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
     *
     * @tag #rules
     */
    public function rules(): array
    {
        return [
            [self::ATTR_PASSWORD, 'required'],
            [self::ATTR_PASSWORD, 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * @return Identity
     *
     * @tag #getter #identity
     */
    public function getIdentity(): Identity
    {
        return $this->_identity;
    }
}
