<?php declare(strict_types=1);

namespace app\frontend\models\forms;

use app\common\services\IdentityService;
use Yii;
use app\common\components\models\EmailingWebForm;
use app\common\models\{ Identity, dto\EmailMessageDto };
use yii\base\InvalidConfigException;

/**
 * < Frontend > `SignupForm`
 *
 * @package app\frontend\models\forms
 *
 * @tag #models #forms #signup
 */
class SignupForm extends EmailingWebForm
{
    public string $id = 'form-signup';

    public const MESSAGE_SUCCESS = 'Благодарим за регистрацию. Пожалуйста, проверьте свой почтовый ящик.';
    public const MESSAGE_ERROR = 'Ошибка регистрации. Пожалуйста, попробуйте еще раз.';

    public const RULE_EXCEPTION_EMAIL_UNIQUE = 'Этот адрес электронной почты уже занят';
    public const RULE_EXCEPTION_USERNAME_UNIQUE = 'Это имя пользователя уже занято.';

    public const ATTR_USERNAME = 'username';
    public const ATTR_EMAIL = 'email';
    public const ATTR_PASSWORD = 'password';

    public const COMPOSE_MESSAGE_VIEW = [
        'html' => 'emailVerify-html',
        'text' => 'emailVerify-text',
    ];


    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;

    public ?Identity $identity = null;




    /**
     * {@inheritdoc}
     *
     * @return array
     *
     * @tag #models #forms #signup #rules
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

            [self::ATTR_EMAIL, 'unique', 'targetClass' => Identity::class, 'message' => self::RULE_EXCEPTION_EMAIL_UNIQUE],
            [self::ATTR_USERNAME, 'unique', 'targetClass' => Identity::class, 'message' => self::RULE_EXCEPTION_USERNAME_UNIQUE],
        ];
    }

    /**
     * @return EmailMessageDto
     *
     * @tag #models #forms #signup #constructor #dto #email
     * @throws InvalidConfigException
     */
    public function constructEmailDto(): EmailMessageDto
    {
        $emailMessageDto = new EmailMessageDto();
        $emailMessageDto->to = $this->identity->email;
        $emailMessageDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailMessageDto->fromName = Yii::$app->name . ' robot';
        $emailMessageDto->subject = $this->generateMailSubject();

        $emailMessageDto->view = self::COMPOSE_MESSAGE_VIEW;

        $emailMessageDto->params = [
            'user' => IdentityService::getInstance()->findResendVerificationUser($this->email)
        ];

        return $emailMessageDto;
    }

    /**
     * @return string
     *
     * @tag #models #forms #signup #subject
     */
    public function generateMailSubject(): string
    {
        return 'Регистрация аккаунта на сайте ' . Yii::$app->name;
    }
}
