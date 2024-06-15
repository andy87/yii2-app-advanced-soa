<?php declare(strict_types=1);

namespace app\frontend\models\forms;

use app\common\components\models\EmailingModel;
use app\common\services\IdentityService;
use app\common\models\{dto\EmailDto, Identity};
use Yii;
use yii\base\InvalidConfigException;

/**
 * < Frontend > `PasswordResetRequestForm`
 *
 * @package app\frontend\models\forms
 *
 * @tag #models #forms #password #reset #request
 */
class PasswordResetRequestForm extends EmailingModel
{
    public const ATTR_EMAIL = 'email';

    public const MESSAGE_SUCCESS = 'Проверьте свою электронную почту для получения дальнейших инструкций.';
    public const MESSAGE_ERROR = 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.';

    public ?string $composeHtml = 'passwordResetToken-html';
    public ?string $composeView = 'passwordResetToken-text';


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
            $this->identity = IdentityService::getInstance()
                ->findActiveByEmail($this->email);
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
     * @return EmailDto
     *
     * @tag #constructor #dto #email
     */
    public function constructEmailDto(): EmailDto
    {
        $emailDto = new EmailDto();
        $emailDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailDto->fromName = Yii::$app->name . ' robot';
        $emailDto->subject = 'Password reset for ' . Yii::$app->name;
        $emailDto->to = $this->email;

        return $emailDto;
    }
}
