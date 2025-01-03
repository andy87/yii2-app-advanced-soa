<?php declare(strict_types=1);

namespace common\models\forms;

use Exception;
use common\models\Identity;
use common\services\IdentityService;
use yii\base\InvalidConfigException;
use frontend\controllers\AuthController;
use common\components\base\models\forms\BaseWebForm;

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
    public const string ATTR_USERNAME = 'username';
    public const string ATTR_PASSWORD = 'password';
    public const string ATTR_REMEMBER_ME = 'rememberMe';

    public const string RULE_MESSAGE_WRONG_USER_NAME_OR_PASSWORD = 'Неверное имя пользователя или пароль.';

    public const string RULE_REQUIRED_MESSAGE = 'Поле `{attribute}` не может быть пустым';

    public const string HINT = 'Пожалуйста, заполните следующие поля для входа:';
    public const string BUTTON_LOGIN_TEXT = 'Авторизоваться';

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
     * @throws InvalidConfigException|Exception
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