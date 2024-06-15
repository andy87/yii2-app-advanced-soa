<?php declare(strict_types=1);

namespace app\frontend\models\forms;

use app\common\models\Identity;
use IdentityService;
use yii\base\{InvalidArgumentException, InvalidConfigException, Model};

/**
 * < Frontend > `VerifyEmailForm`
 *
 * @package app\frontend\models\forms
 *
 * @tag #models #forms #verify #email
 */
class VerifyEmailForm extends Model
{
    public const MESSAGE_SUCCESS = 'Вы успешно подтвердили свой email!';
    public const MESSAGE_ERROR = 'Извините! Токен неверный, мы не можем подтвердить аккаунт.';



    /**
     * @var ?string
     */
    public ?string $token = null;

    /**
     * @var ?Identity
     */
    private ?Identity $_identity;



    /**
     * Creates a form model with given token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     *
     * @throws InvalidArgumentException|InvalidConfigException
     *
     * @tag #constructor
     */
    public function __construct($token, array $config = [])
    {
        parent::__construct($config);

        if (strlen($token) )
        {
            $this->_identity = IdentityService::getInstance()->findByVerificationToken($token);

            if (!$this->_identity) {
                throw new InvalidArgumentException('Wrong verify email token.');
            }
        }

        throw new InvalidArgumentException('Verify email token cannot be blank.');
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
