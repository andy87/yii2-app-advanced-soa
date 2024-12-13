<?php declare(strict_types=1);

namespace yii2\common\models;

use Yii;
use yii\web\IdentityInterface;
use yii2\common\models\sources\User;
use yii\behaviors\TimestampBehavior;
use yii\base\{ Behavior, Exception, NotSupportedException };

/**
 * User model
 *
 */
class Identity extends User implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


    /**
     * {@inheritdoc}
     *
     * @return Behavior[]|array
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [self::ATTR_STATUS, 'default', 'value' => self::STATUS_INACTIVE],
            [self::ATTR_STATUS, 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @param $id
     *
     * @return Identity|IdentityInterface|null
     */
    public static function findIdentity($id): Identity|IdentityInterface|null
    {
        return static::findOne([self::ATTR_ID => $id, self::ATTR_STATUS => self::STATUS_ACTIVE]);
    }

    /**
     * @param $token
     * @param $type
     *
     * @return ?IdentityInterface
     *
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     *
     * @return ?string
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $authKey
     *
     * @return ?bool
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     *
     * @throws Exception
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     *
     * @throws Exception
     *
     * @return void
     */
    public function generateAuthKey(): void
    {
        $this->setAttribute(self::ATTR_AUTH_KEY, Yii::$app->security->generateRandomString());
    }

    /**
     * Generates new password reset token
     *
     * @throws Exception
     *
     * @return void
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     *
     * @throws Exception
     *
     * @return void
     */
    public function generateEmailVerificationToken(): void
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     *
     * @return void
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }
}
