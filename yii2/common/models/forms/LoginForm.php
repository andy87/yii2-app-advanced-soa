<?php declare(strict_types=1);

namespace yii2\common\models\forms;

use yii\base\InvalidConfigException;
use yii2\common\components\forms\BaseWebForm;
use yii2\frontend\controllers\AuthController;
use yii2\common\{models\Identity, services\IdentityService};

/**
 * < Common > `LoginForm`
 *
 *      Login form
 *
 * @package yii2\common\models\forms
 *
 * @tag #common #forms #login
 */
class LoginForm extends BaseWebForm
{
    public const ATTR_USERNAME = 'username';
    public const ATTR_PASSWORD = 'password';
    public const ATTR_REMEMBER_ME = 'rememberMe';

    public const RULE_MESSAGE_WRONG_USER_NAME_OR_PASSWORD = 'Неверное имя пользователя или пароль.';

    public const RULE_REQUIRED_MESSAGE = 'Поле `{attribute}` не может быть пустым';

    public const HINT = 'Пожалуйста, заполните следующие поля для входа:';
    public const BUTTON_LOGIN_TEXT = 'Авторизоваться';

    public string $id = 'login-form';

    public ?string $username = null;
    public ?string $password = null;
    public bool $rememberMe = true;

    private ?Identity $_identity = null;


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [[self::ATTR_USERNAME, self::ATTR_PASSWORD], 'required', 'message' => self::RULE_REQUIRED_MESSAGE ],
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
        return AuthController::getEndpoint(AuthController::ACTION_REQUEST_PASSWORD_RESET);
    }

    /**
     * @return string
     *
     * @endpoint auth/resend-verification-email
     */
    public function getHrefResendVerificationEmail(): string
    {
        return AuthController::getEndpoint(AuthController::ACTION_RESEND_VERIFICATION_EMAIL);
    }

}
