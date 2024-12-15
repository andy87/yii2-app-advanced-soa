<?php declare(strict_types=1);

namespace yii2\frontend\models\forms;

use yii2\common\components\forms\BaseWebForm;
use yii2\common\models\Identity;
use yii2\common\services\IdentityService;
use Yii;
use yii\base\{InvalidArgumentException, InvalidConfigException};

/**
 * < Frontend > `ResetPasswordForm`
 *
 * @package yii2\frontend\models\forms
 *
 * @tag #models #forms #reset #password
 */
class ResetPasswordForm extends BaseWebForm
{
    public string $id = 'reset-password-form';

    public const ATTR_PASSWORD = 'password';

    public const MESSAGE_SUCCESS = 'Новый пароль был сохранен';
    public const MESSAGE_ERROR = 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.';

    public const EXCEPTION_TOKEN_INVALID = 'Wrong password reset token.';
    public const EXCEPTION_TOKEN_EMPTY_PASSWORD = 'Password reset token cannot be empty.';


    /** @var ?string  */
    public ?string $password = null;

    /**
     * @var ?Identity
     */
    private ?Identity $_identity = null;


    /**
     * Creates a form model given a token.
     *
     * @param string $password
     * @param array $config name-value pairs that will be used to initialize the object properties
     *
     * @throws InvalidArgumentException|InvalidConfigException if token is empty or not valid
     *
     * @tag #constructor
     */
    public function __construct( string $password, array $config = [])
    {
        $this->password = $password;

        if ( strlen($this->password) )
        {
            $this->_identity = IdentityService::getInstance()->findByPasswordResetToken($this->password);

            if ($this->_identity)
            {
                parent::__construct($config);

            } else {

                throw new InvalidArgumentException(self::EXCEPTION_TOKEN_INVALID);
            }
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
     * @return Identity
     *
     * @tag #getter #identity
     */
    public function getIdentity(): Identity
    {
        return $this->_identity;
    }
}
