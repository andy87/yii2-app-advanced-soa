<?php

namespace app\frontend\models\forms;

use app\common\components\models\EmailingModel;
use app\common\models\{dto\EmailDto, Identity};
use Yii;

/**
 * < Frontend > `SignupForm`
 *
 * @package app\frontend\models\forms
 *
 * @tag #models #forms #signup
 */
class SignupForm extends EmailingModel
{
    public const MESSAGE_SUCCESS = 'Благодарим за регистрацию. Пожалуйста, проверьте свой почтовый ящик.';
    public const MESSAGE_ERROR = 'Ошибка регистрации. Пожалуйста, попробуйте еще раз.';

    public const ATTR_USERNAME = 'username';
    public const ATTR_EMAIL = 'email';
    public const ATTR_PASSWORD = 'password';


    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;

    public Identity $identity;

    public ?string $composeHtml = 'emailVerify-html';
    public ?string $composeView = 'emailVerify-text';



    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[self::ATTR_USERNAME, self::ATTR_EMAIL], 'trim'],
            [[self::ATTR_USERNAME, self::ATTR_EMAIL, self::ATTR_PASSWORD], 'required'],
            [self::ATTR_USERNAME, 'string', 'min' => 2, 'max' => 255],

            [self::ATTR_EMAIL, 'email'],
            [self::ATTR_EMAIL, 'string', 'max' => 255],

            [self::ATTR_PASSWORD, 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            [self::ATTR_EMAIL, 'unique', 'targetClass' => Identity::class, 'message' => 'Этот адрес электронной почты уже занят'],
            [self::ATTR_USERNAME, 'unique', 'targetClass' => Identity::class, 'message' => 'Это имя пользователя уже занято.'],
        ];
    }

    /**
     * @return EmailDto
     */
    public function constructEmailDto(): EmailDto
    {
        $emailDto = new EmailDto();
        $emailDto->to = $this->identity->email;
        $emailDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailDto->fromName = Yii::$app->name . ' robot';
        $emailDto->subject = 'Регистрация аккаунта на сайте ' . Yii::$app->name;

        return $emailDto;
    }
}
