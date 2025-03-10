<?php declare(strict_types=1);

namespace yii2\frontend\models\forms;

use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\{components\forms\EmailingWebForm, services\IdentityService};
use yii2\common\models\{dto\EmailMessageDto, Identity};
use Yii;
use yii\base\InvalidConfigException;

/**
 * < Frontend > `PasswordResetRequestForm`
 *
 * @property-read IdentityService $identityService
 *
 * @package yii2\frontend\models\forms
 *
 * @tag #models #forms #password #reset #request
 */
class PasswordResetRequestForm extends EmailingWebForm
{
    use LazyLoadTrait;

    public string $id = 'request-password-reset-form';

    public const MESSAGE_SUCCESS = 'Проверьте свою электронную почту для получения дальнейших инструкций.';
    public const MESSAGE_ERROR = 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.';

    public const ATTR_EMAIL = 'email';


    /** @var ?string   */
    public ?string $email = null;

    public ?string $result = null;

    /** @var ?Identity $identity */
    private ?Identity $identity = null;


    public array $lazyLoadConfig = [
        'identityService' => IdentityService::class
    ];


    /**
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
                'filter' => ['status' => Identity::STATUS_ACTIVE],
                'message' => 'Нет пользователя с таким email.'
            ],
        ];
    }

    /**
     * @return ?Identity
     *
     * @tag #setup #identity
     */
    public function setupIdentity(): ?Identity
    {
        if ($this->identity === null)
        {
            $this->identity = $this->identityService->findActiveByEmail($this->email);
        }

        return $this->identity;
    }

    /**
     * @return ?Identity
     *
     * @throws InvalidConfigException
     *
     * @tag #getter #identity
     */
    public function getIdentity(): ?Identity
    {
        return ($this->identity instanceof Identity ) ? $this->identity : $this->setupIdentity();
    }

    /**
     * @return EmailMessageDto
     *
     * @throws InvalidConfigException
     *
     * @tag #constructor #dto #email
     */
    public function constructEmailDto(): EmailMessageDto
    {
        $emailMessageDto = new EmailMessageDto();
        $emailMessageDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailMessageDto->fromName = Yii::$app->name . ' robot';
        $emailMessageDto->subject = 'Password reset for ' . Yii::$app->name;
        $emailMessageDto->to = $this->email;

        $emailMessageDto->view = [
            'html' => 'passwordResetToken-html',
            'text' => 'passwordResetToken-text',
        ];

        $emailMessageDto->params = [
            'user' => $this->getIdentity()
        ];

        return $emailMessageDto;
    }
}
