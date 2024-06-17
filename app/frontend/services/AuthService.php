<?php declare(strict_types=1);

namespace app\frontend\services;

use Yii;
use Exception;
use app\common\models\Identity;
use yii\base\InvalidConfigException;
use app\common\services\{ EmailService, IdentityService };
use app\frontend\models\forms\{ PasswordResetRequestForm, ResendVerificationEmailForm, ResetPasswordForm, SignupForm, VerifyEmailForm };

/**
 * < Frontend > `AuthService`
 *
 * @package app\frontend\services\controllers
 *
 * @tag #services #auth
 */
class AuthService extends \app\common\services\AuthService
{
    /**
     * @param SignupForm $signupForm
     * @param array $data
     *
     * @throws InvalidConfigException
     *
     * @return ?Identity
     *
     * @tag #service #auth #handler #form #signup
     */
    public function handlerSignupForm(SignupForm $signupForm, array $data = []): ?Identity
    {
        if (count($data)) $signupForm->load($data);

        $transaction = Yii::$app->db->beginTransaction();

        try
        {
            if ($signupForm->validate())
            {
                $signupForm->identity = IdentityService::getInstance()->signUp($signupForm);

                 if ($signupForm->identity->id !== null)
                 {
                     if ( $this->sendEmailVerifyMail($signupForm) )
                     {
                         $transaction?->commit();

                         return $signupForm->identity;

                     } else {
                         $message = 'send EmailVerify error';
                     }
                 } else {
                     $message = 'identity save error';
                 }

            } else {
                $message = 'Signup form validation error';
            }
        } catch (Exception $e) {

            $message = 'Catch `handlerSignupForm`';
            $data = $this->prepareException('Signup form error', $e);
        }

        $transaction?->rollBack();

        $this->runtimeLogError(__METHOD__, $message, $signupForm, $data ?? []);

        return null;
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

        return EmailService::getInstance()->send($registrationEmail);
    }

    /**
     * Обработчик запроса сброса пароля пользователя по email
     *
     * @param PasswordResetRequestForm $passwordResetRequestForm
     * @param array $data
     *
     * @return bool
     *
     * @throws InvalidConfigException|\yii\base\Exception
     *
     * @tag #service #auth #handler #form #passwordResetRequest
     */
    public function handlerRequestPasswordResetResources(PasswordResetRequestForm $passwordResetRequestForm, array $data = []): bool
    {
        if (count($data)) $passwordResetRequestForm->load($data);

        //$transaction = Yii::$app->db->beginTransaction();

        if ($passwordResetRequestForm->validate())
        {
            $identity = $passwordResetRequestForm->getIdentity();

            if ($identity)
            {
                if (Identity::isPasswordResetTokenValid($identity->password_reset_token))
                {
                    try
                    {
                        $identity->generatePasswordResetToken();

                        if ($identity->save())
                        {
                            if ($this->sendEmailRequestPasswordReset($passwordResetRequestForm)) {

                                //$transaction?->commit();
                                return true;

                            } else {
                                $message = 'send EmailRequestPasswordReset error';
                            }
                        } else{
                            $message = 'Identity `save error`';
                        }
                    } catch (Exception $e) {

                        $message = 'Catch `handlerRequestPasswordResetResources`';
                        $data = $this->prepareException('Password reset request error', $e);
                    }
                } else {
                    $message = 'Password reset token `is not valid`';
                }
            } else {
                $message = 'Identity not found';
            }
        } else {
            $message = 'Password reset request form `validation error`';
        }

        //$transaction?->rollBack();

        $this->runtimeLogError(__METHOD__, $message, $passwordResetRequestForm, $data ?? []);

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

        return EmailService::getInstance()->send($requestPasswordResetEmail);
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
    public function handlerResetPasswordForm(ResetPasswordForm $resetPasswordForm, array $data = [] ): bool
    {
        if (count($data)) $resetPasswordForm->load($data);

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
     * @param array $data
     * @return bool
     *
     * @throws InvalidConfigException|\yii\db\Exception
     *
     * @tag #service #auth #handler #verifyEmailResources
     */
    public function handlerAuthVerifyEmailResources(VerifyEmailForm $verifyEmailForm, array $data = []): bool
    {
        if (count($data)) $verifyEmailForm->load($data);

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
     * @param array $data
     *
     * @return bool
     *
     * @throws InvalidConfigException
     *
     * @tag #service #auth #handler #resend #verificationEmail
     */
    public function handlerResendVerificationEmail(ResendVerificationEmailForm $resendVerificationEmailForm, array $data = []): bool
    {
        if (count($data)) $resendVerificationEmailForm->load($data);

        if ( $resendVerificationEmailForm->validate() )
        {
            return $this->sendEmailResendVerification($resendVerificationEmailForm);

        } else {
            $message = 'Resend verification email form `validation error`';
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

        return EmailService::getInstance()->send($resendVerificationEmail);
    }
}