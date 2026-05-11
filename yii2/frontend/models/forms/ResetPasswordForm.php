<?php declare(strict_types=1);

namespace yii2\frontend\models\forms;

use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\forms\BaseWebForm;
use yii2\common\models\Identity;
use yii2\common\services\IdentityService;
use Yii;
use yii\base\{InvalidArgumentException, InvalidConfigException};

/**
 * < Frontend > `ResetPasswordForm`
 *
 * @property-read IdentityService $identityService
 *
 * @package yii2\frontend\models\forms
 *
 * @tag #models #forms #reset #password
 */
class ResetPasswordForm extends BaseWebForm
{
    use LazyLoadTrait;

    public array $lazyLoadConfig = [
        'identityService' => IdentityService::class
    ];

    public string $id = 'reset-password-form';

    public const ATTR_PASSWORD = 'password';

    public const MESSAGE_SUCCESS = 'Новый пароль был сохранен';
    public const MESSAGE_ERROR = 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.';

    public const EXCEPTION_TOKEN_INVALID = 'Wrong password reset token.';
    public const EXCEPTION_TOKEN_EMPTY_PASSWORD = 'Password reset token cannot be empty.';


    /** @var ?string  */
    public ?string $password = null;

    /** @var ?string */
    public ?string $token = null;

    /** @var string|bool|null */
    public string|bool|null $result = null;

    /**
     * @var ?Identity
     */
    private ?Identity $_identity = null;


    /**
     * Создаёт форму нового пароля по token.
     *
     * @param string $token Токен сброса пароля.
     * @param array $config Параметры конфигурации Yii model.
     * @param bool $validateToken Нужно ли сразу искать identity через legacy IdentityService.
     * @return void
     *
     * @throws InvalidArgumentException Если token пустой или не найден legacy-сервисом.
     * @throws InvalidConfigException Если legacy IdentityService настроен неверно.
     *
     * @tag #constructor
     */
    public function __construct(string $token, array $config = [], bool $validateToken = true)
    {
        $this->token = $token;

        if (strlen($this->token))
        {
            if ($validateToken) {
                $this->_identity = $this->identityService->findByPasswordResetToken($this->token);

                if (!$this->_identity) {
                    throw new InvalidArgumentException(self::EXCEPTION_TOKEN_INVALID);
                }
            }

            parent::__construct($config);
        } else {

            throw new InvalidArgumentException(self::EXCEPTION_TOKEN_EMPTY_PASSWORD);
        }
    }

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
            [self::ATTR_PASSWORD, 'required'],
            [self::ATTR_PASSWORD, 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Возвращает identity, найденную legacy token lookup.
     *
     * @return Identity Identity пользователя.
     *
     * @tag #getter #identity
     */
    public function getIdentity(): Identity
    {
        return $this->_identity;
    }
}
