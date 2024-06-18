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

    public const RULE_MESSAGE_WRONG_USER_NAME_OR_PASSWORD = 'Неверное имя пользователя или пароль.';

    public const RULE_REQUIRED_TEMPLATE = 'Поле `{attribute}` не может быть пустым';


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
            [[self::ATTR_USERNAME, self::ATTR_PASSWORD], 'required', 'message' => self::RULE_REQUIRED_TEMPLATE ],
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
     * @return ?Identity
     *
     * @throws InvalidConfigException
     */
    public function getIdentity(): ?Identity
    {
        if ($this->_identity === null)
        {
            $this->_identity = IdentityService::getInstance()->findActiveByUsername($this->username);
        }

        return $this->_identity;
    }

    /**
     * @return array
     *
     * @tag #common #forms #login #labels
     */
    public function attributeLabels(): array
    {
        return [
            self::ATTR_USERNAME => 'Имя пользователя',
            self::ATTR_PASSWORD => 'Пароль',
            self::ATTR_REMEMBER_ME => 'Запомнить меня',
        ];
    }

    /**
     * @return string
     *
     * @endpoint auth/request-password-reset
     */
    public function getHrefRequestPasswordReset(): string
    {
        return AuthController::ENDPOINT . '/' . AuthController::ACTION_REQUEST_PASSWORD_RESET;
    }

    /**
     * @return string
     *
     * @endpoint auth/resend-verification-email
     */
    public function getHrefResendVerificationEmail(): string
    {
        return AuthController::ENDPOINT . '/' . AuthController::ACTION_RESEND_VERIFICATION_EMAIL;
    }

}
