<?php declare(strict_types=1);

namespace app\frontend\models\forms;

use Yii;
use app\common\models\dto\EmailMessageDto;
use app\frontend\components\models\BaseSendForm;

/**
 * < Frontend > `ContactForm`
 *
 *      ContactForm is the model behind the contact form.
 *
 * @package app\frontend\models
 *
 * @tag #models #forms #contact
 */
class ContactForm extends BaseSendForm
{
    public string $id = 'contact-form';

    public const ATTR_NAME = 'name';
    public const ATTR_EMAIL = 'email';
    public const ATTR_SUBJECT = 'subject';
    public const ATTR_BODY = 'body';
    public const ATTR_VERIFY_CODE = 'verifyCode';


    public const MESSAGE_SUCCESS = 'Спасибо за обращение к нам. Мы ответим вам как можно скорее.';
    public const MESSAGE_ERROR = 'При отправке вашего сообщения произошла ошибка.';



    public ?string $name = null;
    public ?string $email = null;
    public ?string $subject = null;
    public ?string $body = null;
    public ?string $verifyCode = null;


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [[self::ATTR_NAME, self::ATTR_EMAIL, self::ATTR_SUBJECT, self::ATTR_BODY], 'required'],
            [self::ATTR_EMAIL, 'email'],
            [self::ATTR_VERIFY_CODE, 'captcha'],
        ];
    }

    /**
     * @return string[]
     *
     * @tag #getter #labels
     */
    public function attributeLabels(): array
    {
        return [
            self::ATTR_NAME => 'Имя',
            self::ATTR_EMAIL => 'Email',
            self::ATTR_SUBJECT => 'Тема',
            self::ATTR_BODY => 'Сообщение',
            self::ATTR_VERIFY_CODE => 'Капча',
        ];
    }

    /**
     * @return EmailMessageDto
     *
     * @tag #constructor #dto #email
     */
    public function constructEmailDto(): EmailMessageDto
    {
        $emailDto = new EmailMessageDto();

        $emailDto->to = Yii::$app->params['adminEmail'];
        $emailDto->fromEmail = Yii::$app->params['senderEmail'];
        $emailDto->fromName = Yii::$app->params['senderName'];
        $emailDto->ReplyToEmail = $this->email;
        $emailDto->ReplyToName = $this->name;
        $emailDto->subject = $this->subject;
        $emailDto->body = $this->body;

        return $emailDto;
    }
}
