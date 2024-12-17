<?php declare(strict_types=1);

namespace yii2\frontend\models\forms;

use yii2\common\components\forms\BaseWebForm;
use yii2\common\models\dto\EmailMessageDto;
use Yii;

/**
 * < Frontend > `ContactForm`
 *
 *      ContactForm is the model behind the contact form.
 *
 * @package yii2\frontend\models
 *
 * @tag #models #forms #contact
 */
class ContactForm extends BaseWebForm
{
    public const string HEADER = 'Обратная связь';

    public const string HINT = 'Если у вас есть деловые запросы или другие вопросы, пожалуйста, заполните следующую форму, чтобы связаться с нами. Спасибо.';

    public const string ATTR_NAME = 'name';
    public const string ATTR_EMAIL = 'email';
    public const string ATTR_SUBJECT = 'subject';
    public const string ATTR_BODY = 'body';
    public const string ATTR_VERIFY_CODE = 'verifyCode';


    public const string MESSAGE_SUCCESS = 'Спасибо за обращение к нам. Мы ответим вам как можно скорее.';
    public const string MESSAGE_ERROR = 'При отправке вашего сообщения произошла ошибка.';

    public const string RULE_REQUIRED_MESSAGE = 'Поле `{attribute}` не может быть пустым';
    public const string RULE_VERIFY_CODE_MESSAGE = 'Неверный код проверки';

    public const string BUTTON_SEND_TEXT = 'Отправить';


    public string $id = 'contact-form';

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
            [[self::ATTR_NAME, self::ATTR_EMAIL, self::ATTR_SUBJECT, self::ATTR_BODY], 'required', 'message' => self::RULE_REQUIRED_MESSAGE],
            [self::ATTR_EMAIL, 'email'],
            [self::ATTR_VERIFY_CODE, 'captcha', 'message' => self::RULE_VERIFY_CODE_MESSAGE],
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
