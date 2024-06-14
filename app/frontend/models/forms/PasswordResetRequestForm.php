<?php

namespace app\frontend\models\forms;

use Yii;
use app\common\models\{ User, dto\EmailDto };
use app\frontend\components\model\EmailingModel;

/**
 * Class `PasswordResetRequestForm`
 *
 * @package app\frontend\models\forms
 */
class PasswordResetRequestForm extends EmailingModel
{
    public const ATTR_EMAIL = 'email';

    public const MESSAGE_SUCCESS = 'Check your email for further instructions.';
    public const MESSAGE_ERROR = 'Sorry, we are unable to reset password for the provided email address.';

    public string $composeHtml = 'passwordResetToken-html';
    public string $composeView = 'passwordResetToken-text';


    /** @var ?string   */
    public ?string $email = null;

    /** @var ?User  */
    public ?User $user = null;


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [self::ATTR_EMAIL, 'trim'],
            [self::ATTR_EMAIL, 'required'],
            [self::ATTR_EMAIL, 'email'],
            [self::ATTR_EMAIL, 'exist',
                'targetClass' => \app\common\models\User::class,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Нет пользователя с таким email.'
            ],
        ];
    }

    /**
     * @return EmailDto
     */
    public function constructEmailDto(): EmailDto
    {
        $emailDto = new EmailDto();
        $emailDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailDto->fromName = Yii::$app->name . ' robot';
        $emailDto->subject = 'Password reset for ' . Yii::$app->name;
        $emailDto->to = $this->email;

        return $emailDto;
    }
}
