<?php declare(strict_types=1);

namespace yii2\frontend\models\forms;

use Yii;
use yii2\common\models\Identity;
use yii\base\InvalidConfigException;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\services\IdentityService;
use yii2\common\models\dto\EmailMessageDto;
use yii2\common\components\forms\EmailingWebForm;

/**
 * < Frontend > `ResendVerificationEmailForm`
 *
 * @property-read IdentityService $identityService
 *
 * @package yii2\frontend\models\forms
 *
 * @tag #models #forms #resend #verification #email
 */
class ResendVerificationEmailForm extends EmailingWebForm
{
    use LazyLoadTrait;

    public string $id = 'resend-verification-email-form';

    public const TITLE = 'Отправить повторное письмо подтверждения email';
    public const HINT = 'Пожалуйста, введите ваш email, на который будет отправлено письмо с подтверждением.';

    public const ATTR_EMAIL = 'email';
    public const MESSAGE_SUCCESS = 'Проверьте свою почту для получения дальнейших инструкций.';
    public const MESSAGE_ERROR = 'Извините, мы не можем отправить письмо для подтверждения на указанный адрес электронной почты.';

    public const RULE_EXIST_MESSAGE = 'Пользователь с таким адресом электронной почты не найден.';


    /**
     * @var ?string
     */
    public ?string $email = null;

    public ?string $result = null;

    public array $lazyLoadConfig = [
        'identityService' => IdentityService::class
    ];



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
     * @return EmailMessageDto
     *
     * @tag #constructor #dto #email
     */
    public function constructEmailDto(): EmailMessageDto
    {
        $emailMessageDto = new EmailMessageDto();
        $emailMessageDto->to = $this->email;
        $emailMessageDto->subject = $this->generateMailSubject();
        $emailMessageDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailMessageDto->fromName = Yii::$app->name . ' robot';

        $emailMessageDto->view = SignupForm::COMPOSE_MESSAGE_VIEW;

        $emailMessageDto->params = [
            'user' => $this->identityService->findResendVerificationUser($this->email)
        ];

        return $emailMessageDto;
    }

    /**
     * @return string
     *
     * @tag #generate #subject
     */
    public function generateMailSubject(): string
    {
        return 'Account registration at ' . Yii::$app->name;
    }
}
