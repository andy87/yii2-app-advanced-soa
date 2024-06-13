<?php declare(strict_types=1);

namespace app\frontend\services\controllers;

use app\common\components\core\BaseService;
use app\common\models\dto\EmailDto;
use app\common\models\LoginForm;
use app\common\models\User;
use app\common\services\EmailService;
use app\frontend\models\forms\SignupForm;
use app\frontend\services\models\UserService;
use Exception;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Class `AuthService`
 *
 * @package app\frontend\services\controllers
 */
class AuthService extends BaseService
{
    /**
     * @param LoginForm $loginForm
     *
     * @param array $data
     *
     * @return bool
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
                     $user = UserService::getInstance()->signup($signupForm);

                     if ($user->id)
                     {
                         if ( $this->sendRegistrationEmailByUser($user) )
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
                    ];

                    $transaction->rollBack();
                }
           } else {
               $message = 'Signup form load error';
           }
        } else {
            $message = 'Signup form validation error';
        }

        Yii::error([
            'message' => $message,
            'errors' => $signupForm->errors,
            'attributes' => $signupForm->attributes,
        ]);

        return false;
    }

    /**
     * Sends confirmation email to user
     *
     * @param User $user user model to with email should be send
     *
     * @return bool whether the email was sent
     * @throws InvalidConfigException
     */
    public function sendRegistrationEmailByUser(User $user): bool
    {
        $registrationEmail = $this->constructRegistrationEmailByUser($user);

        return EmailService::getInstance()
            ->sendEmail($registrationEmail, [
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            ]);
    }

    /**
     * @param User $user
     *
     * @return EmailDto
     */
    public function constructRegistrationEmailByUser(User $user): EmailDto
    {
        $emailDto = new EmailDto();
        $emailDto->to = $user->email;
        $emailDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailDto->fromName = Yii::$app->name . ' robot';
        $emailDto->subject = 'Account registration at ' . Yii::$app->name;

        return $emailDto;
    }
}