<?php

namespace app\frontend\models\forms;

use app\common\models\dto\EmailDto;
use app\common\models\Identity;
use app\frontend\components\model\EmailingModel;
use Yii;

/**
 * Class `ResendVerificationEmailForm`
 *
 * @package app\frontend\models\forms
 */
class ResendVerificationEmailForm extends EmailingModel
{
    public const ATTR_EMAIL = 'email';
    public const MESSAGE_SUCCESS = 'Проверьте свою почту для получения дальнейших инструкций.';
    public const MESSAGE_ERROR = 'Извините, мы не можем отправить письмо для подтверждения на указанный адрес электронной почты.';

    public ?string $composeHtml = 'emailVerify-html';
    public ?string $composeText = 'emailVerify-text';


    /**
     * @var ?string
     */
    public ?string $email = null;



    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [self::ATTR_EMAIL, 'trim'],
            [self::ATTR_EMAIL, 'required'],
            [self::ATTR_EMAIL, 'email'],
            [self::ATTR_EMAIL, 'exist',
                'targetClass' => Identity::class,
                'filter' => ['status' => Identity::STATUS_INACTIVE],
                'message' => 'Пользователь с таким адресом электронной почты не найден.'
            ],
        ];
    }

    /**
     * @return EmailDto
     */
    public function constructEmailDto(): EmailDto
    {
        $emailDto = new EmailDto();
        $emailDto->to = $this->email;
        $emailDto->subject = 'Account registration at ' . Yii::$app->name;
        $emailDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailDto->fromName = Yii::$app->name . ' robot';

        return $emailDto;
    }
}
