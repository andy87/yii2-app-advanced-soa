<?php declare(strict_types=1);

namespace app\frontend\models\forms;

use app\common\models\Identity;
use app\common\services\IdentityService;
use app\frontend\components\models\BaseSendForm;
use yii\base\{ InvalidArgumentException, InvalidConfigException };

/**
 * < Frontend > `VerifyEmailForm`
 *
 * @package app\frontend\models\forms
 *
 * @tag #models #forms #verify #email
 */
class VerifyEmailSendForm extends BaseSendForm
{
    public string $id = 'verify-email-form';

    public const MESSAGE_SUCCESS = 'Вы успешно подтвердили свой email!';
    public const MESSAGE_ERROR = 'Извините! Токен неверный, мы не можем подтвердить аккаунт.';

    public const EXCEPTION_TOKEN_INVALID = 'Wrong verify email token.';
    public const EXCEPTION_TOKEN_EMPTY = 'Verify email token cannot be blank.';



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

        $this->token = $token;

        if (strlen($this->token) )
        {
            $this->_identity = IdentityService::getInstance()->findByVerificationToken($this->token);

            if (!$this->_identity) {
                throw new InvalidArgumentException(self::EXCEPTION_TOKEN_INVALID);
            }
        } else {
            throw new InvalidArgumentException(self::EXCEPTION_TOKEN_EMPTY);
        }
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
