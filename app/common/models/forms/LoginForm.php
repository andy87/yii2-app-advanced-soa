<?php declare(strict_types=1);

namespace app\common\models\forms;

use app\frontend\controllers\AuthController;
use yii\base\{ InvalidConfigException, Model };
use app\common\{ models\Identity, services\IdentityService };
use Yii;

/**
 * < Common > `LoginForm`
 *
 *      Login form
 *
 * @package app\common\models\forms
 *
 * @tag #common #forms #login
 */
class LoginForm extends Model
{
    public const ID = 'login-form';
    public const ATTR_USERNAME = 'username';
    public const ATTR_PASSWORD = 'password';
    public const ATTR_REMEMBER_ME = 'rememberMe';

    public const RULE_MESSAGE_WRONG_PASSWORD = 'Неверный пароль.';
    public const RULE_MESSAGE_WRONG_USER_NAME_OR_PASSWORD = 'Неверное имя пользователя или пароль.';



    public ?string $username = null;
    public ?string $password = null;
    public bool $rememberMe = false;

    private ?Identity $_identity = null;


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [[self::ATTR_USERNAME, self::ATTR_PASSWORD], 'required'],
            [self::ATTR_REMEMBER_ME, 'boolean'],
            [self::ATTR_PASSWORD, 'validatePassword'], /** @see validatePassword */
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     *
     * @throws InvalidConfigException
     */
    public function validatePassword(string $attribute): void
    {
        if (!$this->hasErrors())
        {
            $identity = $this->getIdentity();

            if ( !$identity || !$identity->validatePassword($this->password))
            {
                $this->addError($attribute, self::RULE_MESSAGE_WRONG_USER_NAME_OR_PASSWORD);
            }
        }
    }

    /**
     * @return array
     */
    public function getHrefRequestPasswordReset(): array
    {
        return [AuthController::ENDPOINT . '/' . AuthController::ACTION_REQUEST_PASSWORD_RESET]; // 'auth/request-password-reset'
    }

    /**
     * @return array
     */
    public function getHrefResendVerificationEmail(): array
    {
        return [AuthController::ENDPOINT . '/' . AuthController::ACTION_RESEND_VERIFICATION_EMAIL]; // 'auth/resend-verification-email'
    }

    /**
     * Finds user by [[username]]
     *
     * @return ?Identity
     *
     * @throws InvalidConfigException
     */
    public function getIdentity(): ?Identity
    {
        if ($this->_identity === null) {
            $this->_identity = IdentityService::getInstance()->findByUsername($this->username);
        }

        if ($this->username && $this->password) {
            if ( !$this->_identity ) {
                $this->addError(self::ATTR_PASSWORD, self::RULE_MESSAGE_WRONG_USER_NAME_OR_PASSWORD);
            }
        }

        return $this->_identity;
    }
}
