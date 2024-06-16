<?php declare(strict_types=1);

namespace app\frontend\models\forms;

use app\common\components\models\EmailingModel;
use app\common\models\{dto\EmailDto, Identity};
use Yii;

/**
 * < Frontend > `ResendVerificationEmailForm`
 *
 * @package app\frontend\models\forms
 *
 * @tag #models #forms #resend #verification #email
 */
class ResendVerificationEmailForm extends EmailingModel
{
    public const ATTR_EMAIL = 'email';
    public const MESSAGE_SUCCESS = 'Проверьте свою почту для получения дальнейших инструкций.';
    public const MESSAGE_ERROR = 'Извините, мы не можем отправить письмо для подтверждения на указанный адрес электронной почты.';

    public const RULE_EXIST_MESSAGE = 'Пользователь с таким адресом электронной почты не найден.';

    protected array $messageConfig = [
        'html' => 'emailVerify-html',
        'text' => 'emailVerify-text',
    ];


    /**
     * @var ?string
     */
    public ?string $email = null;



    /**
     * {@inheritdoc}
     *
     * @return array
     *
     * @tag #rules
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
                'message' => self::RULE_EXIST_MESSAGE
            ],
        ];
    }

    /**
     * @return EmailDto
     *
     * @tag #constructor #dto #email
     */
    public function constructEmailDto(): EmailDto
    {
        $emailDto = new EmailDto();
        $emailDto->to = $this->email;
        $emailDto->subject = $this->generateSubject();
        $emailDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailDto->fromName = Yii::$app->name . ' robot';

        return $emailDto;
    }

    /**
     * @return string
     *
     * @tag #generate #subject
     */
    public function generateSubject(): string
    {
        return 'Account registration at ' . Yii::$app->name;
    }
}
