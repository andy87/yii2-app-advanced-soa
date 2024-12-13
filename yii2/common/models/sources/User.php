<?php declare(strict_types=1);

namespace yii2\common\models\sources;

/**
 * < Common > `User`
 *
 * @package yii2\common\models\sources
 *
 * @source php yii gii/model --tableName=user --modelClass=UserSource --baseClass=yii2\common\components\core\BaseModel --ns=yii2\common\models\sources --generateLabelsFromComments --overwrite=1
 */
class User extends UserSource
{
    public const ATTR_USERNAME = 'username';
    public const ATTR_PASSWORD = 'password';
    public const ATTR_EMAIL = 'email';
    public const ATTR_AUTH_KEY = 'auth_key';
    public const ATTR_PASSWORD_HASH = 'password_hash';
    public const ATTR_PASSWORD_RESET = 'password_reset_token';
    public const ATTR_VERIFICATION = 'verification_token';
    public const ATTR_STATUS = 'status';
    public const ATTR_CREATED_AT = 'created_at';
    public const ATTR_UPDATED_AT = 'updated_at';


    public ?string $password = null;
}