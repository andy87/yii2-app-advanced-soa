<?php declare(strict_types=1);

namespace app\frontend\models\forms;

use app\common\models\dto\EmailDto;
use Yii;
use yii\base\Model;

/**
 * Class `ContactForm`
 *
 *      ContactForm is the model behind the contact form.
 *
 * @package app\frontend\models
 */
class ContactForm extends Model
{
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
     * @return EmailDto
     */
    public function constructEmail(): EmailDto
    {
        $emailDto = new EmailDto();

        $emailDto->to = $this->email;
        $emailDto->fromEmail = Yii::$app->params['senderEmail'];
        $emailDto->fromName = Yii::$app->params['senderName'];
        $emailDto->ReplyToEmail = $this->email;
        $emailDto->ReplyToName = $this->name;
        $emailDto->subject = $this->subject;
        $emailDto->body = $this->body;

        return $emailDto;
    }
}
