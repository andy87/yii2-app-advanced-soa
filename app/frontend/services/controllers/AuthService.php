<?php declare(strict_types=1);

namespace app\frontend\services\controllers;

use app\common\components\core\BaseService;
use app\common\models\Identity;
use app\common\models\LoginForm;
use app\common\services\EmailService;
use app\frontend\models\forms\PasswordResetRequestForm;
use app\frontend\models\forms\ResendVerificationEmailForm;
use app\frontend\models\forms\ResetPasswordForm;
use app\frontend\models\forms\SignupForm;
use app\frontend\models\forms\VerifyEmailForm;
use Exception;
use IdentityService;
use Yii;
use yii\base\InvalidConfigException;

/**
 * < Frontend > `AuthService`
 *
 * @package app\frontend\services\controllers
 *
 * @tag #services #auth
 */
class AuthService extends BaseService
{
    /**
     * @param LoginForm $loginForm
     *
     * @param array $data
     *
     * @return bool
     * 
     * @tag #service #auth #handler #form #login
     */
    public function handlerLoginForm(LoginForm $loginForm, array $data): bool
    {
        if ( $loginForm->load( $data ) )
        {
            return $loginForm->login();
        }

        return false;
    }

    /**
     * @return bool
     *
     * @tag #service #auth #logout
     */
    public function logout(): bool
    {
        return Yii::$app->user->logout();
    }

    /**
     * @param SignupForm $signupForm
     * @param array $data
     *
     * @return bool
     *
     * @tag #service #auth #handler #form #signup
     */
    public function handlerSignupForm(SignupForm $signupForm, array $data): bool
    {
        if ($signupForm->validate())
        {
           if ( $signupForm->load( $data ) )
           {
               $transaction = Yii::$app->db->beginTransaction();

                try
                {
                    $Identity = IdentityService::getInstance()->createItem($signupForm);

                     if ($Identity->id !== null)
                     {
                         $signupForm->identity = $Identity;

                         if ( $this->sendEmailVerifyMail($signupForm) )
                         {
                             $transaction->commit();

                             return true;

                         } else {
                             $message = 'Signup form email error';
                         }
                     } else {
                         $message = 'User save error';
                     }

                } catch (Exception $e) {

                    $message = [
                        'catch' => 'Signup form error',
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                    ];

                    $transaction->rollBack();
                }
           } else {
               $message = 'Signup form load error';
           }
        } else {
            $message = 'Signup form validation error';
        }

        $this->runtimeLogError(__METHOD__, $message, $signupForm);

        return false;
    }

    /**
     * @param SignupForm $signupForm
     *
     * @return bool
     *
     * @throws InvalidConfigException
     *
     * @tag #service #auth #send #email #verifyMail
     */
    public function sendEmailVerifyMail(SignupForm $signupForm): bool
    {
        $registrationEmail = $signupForm->constructEmailDto();

        $configCompose = $signupForm->getEmailComposeConfig(['user' => $signupForm->identity]);

        return EmailService::getInstance()
            ->send($registrationEmail, $configCompose);
    }

    /**
     * Обработчик запроса сброса пароля пользователя по email
     *
     * @param PasswordResetRequestForm $passwordResetRequestForm
     * @param array $data
     *
     * @return bool
     *
     * @throws InvalidConfigException|\yii\db\Exception|\yii\base\Exception
     *
     * @tag #service #auth #handler #form #passwordResetRequest
     */
    public function handlerRequestPasswordResetResources(PasswordResetRequestForm $passwordResetRequestForm, array $data): bool
    {
        if ($passwordResetRequestForm->load($data) )
        {
            if ($passwordResetRequestForm->validate())
            {
                $passwordResetRequestForm->_identity = IdentityService::getInstance()->findActiveUserByEmail($passwordResetRequestForm->email);

                if ($passwordResetRequestForm->_identity)
                {
                    if (Identity::isPasswordResetTokenValid($passwordResetRequestForm->_identity->password_reset_token))
                    {
                        $passwordResetRequestForm->_identity->generatePasswordResetToken();

                        if ($passwordResetRequestForm->_identity->save())
                        {
                            return $this->sendEmailRequestPasswordReset($passwordResetRequestForm);

                        } else{
                            $message = 'User `save error`';
                        }
                    } else {
                        $message = 'Password reset token `is not valid`';
                    }
                } else {
                    $message = 'User not found';
                }
            } else {
                $message = 'Password reset request form `validation error`';
            }

        } else {
            $message = 'Password reset request form `validation error`';
        }

        $this->runtimeLogError(__METHOD__, $message, $passwordResetRequestForm);

        return false;
    }

    /**
     * Отправка письма для сброса пароля пользователя по email
     *      из формы запроса сброса пароля `PasswordResetRequestForm`
     *
     * @param PasswordResetRequestForm $passwordResetRequestForm
     * 
     * @return bool
     * 
     * @throws InvalidConfigException
     * 
     * @tag #service #auth #send #email #requestPasswordReset
     */
    public function sendEmailRequestPasswordReset(PasswordResetRequestForm $passwordResetRequestForm): bool
    {
        $requestPasswordResetEmail = $passwordResetRequestForm->constructEmailDto();

        $configCompose = $passwordResetRequestForm->getEmailComposeConfig([
            'user' => $passwordResetRequestForm->_identity
        ]);

        return EmailService::getInstance()
            ->send($requestPasswordResetEmail, $configCompose);
    }

    /**
     * @param ResetPasswordForm $resetPasswordForm
     * @param array $data
     *
     * @return bool
     *
     * @throws \yii\base\Exception
     *
     * @tag #service #auth #handler #resetPasswordForm
     */
    public function handlerResetPasswordForm(ResetPasswordForm $resetPasswordForm, array $data ): bool
    {
        if ($resetPasswordForm->load($data)) {

            if ($resetPasswordForm->validate())
            {
                if ($this->resetPassword($resetPasswordForm))
                {
                    return true;

                } else {
                    $message = 'Reset password form `save error`';
                }
            } else {
                $message = 'Reset password form `validation error`';
            }
        } else {
            $message = 'Reset password form `load error`';
        }

        $this->runtimeLogError(__METHOD__, $message, $resetPasswordForm);

        return false;
    }

    /**
     * @return bool if password was reset.
     *
     * @throws \yii\base\Exception
     *
     * @tag #service #auth #resetPassword
     */
    public function resetPassword(ResetPasswordForm $resetPasswordForm): bool
    {
        $identity = $resetPasswordForm->getIdentity();

        $identity->setPassword($resetPasswordForm->password);

        $identity->removePasswordResetToken();

        $identity->generateAuthKey();

        return $identity->save(false);
    }

    /**
     * @param VerifyEmailForm $verifyEmailForm
     *
     * @return bool
     *
     * @throws \yii\db\Exception
     *
     * @tag #service #auth #handler #verifyEmailResources
     */
    public function handlerAuthVerifyEmailResources(VerifyEmailForm $verifyEmailForm): bool
    {
        $identity = $this->verify($verifyEmailForm);

        if ( $identity )
        {
            return Yii::$app->user->login($identity);

        } else {

            $message = 'Verify email form `save error`';
        }

        $this->runtimeLogError(__METHOD__, $message, $verifyEmailForm);

        return false;
    }

    /**
     * @param VerifyEmailForm $verifyEmailForm
     *
     * @return ?Identity
     *
     * @throws \yii\db\Exception
     *
     * @tag #service #auth #verify
     */
    public function verify( VerifyEmailForm $verifyEmailForm ): ?Identity
    {
        $identity = $verifyEmailForm->getIdentity();

        $identity->status = Identity::STATUS_ACTIVE;

        return $identity->save(false) ? $identity : null;
    }

    /**
     * @param ResendVerificationEmailForm $resendVerificationEmailForm
     *
     * @param mixed $post
     *
     * @return bool
     *
     * @throws InvalidConfigException
     *
     * @tag #service #auth #handler #resend #verificationEmail
     */
    public function handlerResendVerificationEmail(ResendVerificationEmailForm $resendVerificationEmailForm, array $post): bool
    {
        if ( $resendVerificationEmailForm->load($post) )
        {
            if ( $resendVerificationEmailForm->validate() )
            {
                return $this->sendEmailResendVerification($resendVerificationEmailForm);

            } else {
                $message = 'Resend verification email form `validation error`';
            }
        } else {
            $message = 'Resend verification email form `load error`';
        }

        $this->runtimeLogError(__METHOD__, $message, $resendVerificationEmailForm);

        return false;
    }

    /**
     * @param ResendVerificationEmailForm $resendVerificationEmailForm
     *
     * @return bool
     *
     * @throws InvalidConfigException
     *
     * @tag #service #auth #send #email #resendVerification
     */
    public function sendEmailResendVerification(ResendVerificationEmailForm $resendVerificationEmailForm): bool
    {
        $resendVerificationEmail = $resendVerificationEmailForm->constructEmailDto();

        $user = IdentityService::getInstance()->findResendVerificationUser($resendVerificationEmailForm->email);

        $configCompose = $resendVerificationEmailForm->getEmailComposeConfig([ 'user' => $user ]);

        return EmailService::getInstance()
            ->send($resendVerificationEmail, $configCompose);
    }
}