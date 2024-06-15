<?php declare(strict_types=1);

namespace app\common\models;

use Yii;
use yii\base\Model;
use app\frontend\controllers\AuthController;

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
     */
    public function validatePassword(string $attribute): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
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
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Identity|null
     */
    protected function getUser(): ?Identity
    {
        if ($this->_user === null) {
            $this->_user = Identity::findByUsername($this->username);
        }

        return $this->_user;
    }
}
