<?php declare(strict_types=1);

namespace yii2\frontend\models\forms;

use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\forms\BaseWebForm;
use yii2\common\models\Identity;
use yii2\common\services\IdentityService;
use yii\base\{InvalidArgumentException, InvalidConfigException};

/**
 * < Frontend > `VerifyEmailForm`
 *
 * @property-read IdentityService $identityService
 *
 * @package yii2\frontend\models\forms
 *
 * @tag #models #forms #verify #email
 */
class VerifyEmailForm extends BaseWebForm
{
    use LazyLoadTrait;

    public string $id = 'verify-email-form';

    public const MESSAGE_SUCCESS = 'Вы успешно подтвердили свой email!';
    public const MESSAGE_ERROR = 'Извините! Токен неверный, мы не можем подтвердить аккаунт.';

    public const EXCEPTION_TOKEN_INVALID = 'Wrong verify email token.';
    public const EXCEPTION_TOKEN_EMPTY = 'Verify email token cannot be blank.';
    public const EXCEPTION_TOKEN_MISSING = 'Missing required parameters: token';

    public array $lazyLoadConfig = [
        'identityService' => IdentityService::class
    ];



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
    public function __construct( string $token, array $config = [] )
    {
        if ( empty($token) ){
            throw new InvalidArgumentException(self::EXCEPTION_TOKEN_EMPTY );
        }

        $this->_identity = $this->identityService->findInactiveByVerificationToken( $token );

        if ( !$this->_identity ) {
            throw new InvalidArgumentException(self::EXCEPTION_TOKEN_INVALID );
        }

        parent::__construct($config);
    }

    /**
     * @return ?Identity
     *
     * @tag #getter #identity
     */
    public function getIdentity(): ?Identity
    {
        return $this->_identity;
    }
}
