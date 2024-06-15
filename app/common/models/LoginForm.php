<?php declare(strict_types=1);

namespace app\common\models;

use Yii;
use app\common\services\IdentityService;
use app\frontend\controllers\AuthController;
use yii\base\{Model, InvalidConfigException };

/**
 * Login form
 *
 * @property ?Identity $user
 */
class LoginForm extends Model
{
    public const ATTR_USERNAME = 'username';
    public const ATTR_PASSWORD = 'password';
    public const ATTR_REMEMBER_ME = 'rememberMe';



    public ?string $username = null;
    public ?string $password = null;
    public bool $rememberMe = false;

    private ?Identity $_user = null;


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
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверное имя пользователя или пароль.');
            }
        }
    }

    /**
     * @return array
     */
    public function getHrefRequestPasswordReset(): array
    {
        return [AuthController::ENDPOINT . '/' . AuthController::ACTION_REQUEST_PASSWORD_RESET];
    }

    /**
     * @return array
     */
    public function getHrefResendVerificationEmail(): array
    {
        return [AuthController::ENDPOINT . '/' . AuthController::ACTION_RESEND_VERIFICATION_EMAIL];
    }

    /**
     * Finds user by [[username]]
     *
     * @return ?Identity
     *
     * @throws InvalidConfigException
     */
    public function getUser(): ?Identity
    {
        if ($this->_user === null) {
            $this->_user = IdentityService::getInstance()
                ->findByUsername($this->username);
        }

        return $this->_user;
    }
}
