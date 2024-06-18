<?php declare(strict_types=1);

namespace app\frontend\models\forms;

use Yii;
use yii\base\InvalidConfigException;
use app\common\models\{ Identity, dto\EmailMessageDto };
use app\common\{ services\IdentityService, components\models\EmailingSendForm };

/**
 * < Frontend > `PasswordResetRequestForm`
 *
 * @package app\frontend\models\forms
 *
 * @tag #models #forms #password #reset #request
 */
class PasswordResetRequestForm extends EmailingSendForm
{
    public string $id = 'request-password-reset-form';

    public const MESSAGE_SUCCESS = 'Проверьте свою электронную почту для получения дальнейших инструкций.';
    public const MESSAGE_ERROR = 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.';

    public const ATTR_EMAIL = 'email';


    /** @var ?string   */
    public ?string $email = null;

    /** @var ?Identity $identity */
    private ?Identity $identity = null;


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
     * @throws InvalidConfigException
     *
     * @tag #setup #identity
     */
    public function setupIdentity(): ?Identity
    {
        if ($this->identity === null)
        {
            $this->identity = IdentityService::getInstance()->findActiveByEmail($this->email);
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
