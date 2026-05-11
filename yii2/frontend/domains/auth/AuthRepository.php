<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth;

use andy87\yii2dnk\domain\BaseRepository;
use yii2\common\models\Identity;
use yii2\common\models\sources\User;

/**
 * DNK repository домена авторизации.
 *
 * Отвечает только за чтение Identity-модели для login/reset-password сценариев.
 */
class AuthRepository extends BaseRepository
{
    protected const DOMAIN = AuthDomain::class;

    /**
     * Ищет активного пользователя по username.
     *
     * @param string|null $username Имя пользователя из формы входа.
     * @return Identity|null Найденная активная identity или null.
     * @throws \yii\base\InvalidConfigException Если модель домена настроена неверно.
     */
    public function findActiveByUsername(?string $username): ?Identity
    {
        if ($username === null || $username === '') {
            return null;
        }

        /** @var Identity|null $identity */
        $identity = $this->findOne([
            User::ATTR_USERNAME => $username,
            User::ATTR_STATUS => Identity::STATUS_ACTIVE,
        ]);

        return $identity;
    }

    /**
     * Ищет активного пользователя по email.
     *
     * @param string|null $email Email пользователя.
     * @return Identity|null Найденная активная identity или null.
     * @throws \yii\base\InvalidConfigException Если модель домена настроена неверно.
     */
    public function findActiveByEmail(?string $email): ?Identity
    {
        if ($email === null || $email === '') {
            return null;
        }

        /** @var Identity|null $identity */
        $identity = $this->findOne([
            User::ATTR_EMAIL => $email,
            User::ATTR_STATUS => Identity::STATUS_ACTIVE,
        ]);

        return $identity;
    }

    /**
     * Ищет неактивного пользователя по email.
     *
     * @param string|null $email Email пользователя.
     * @return Identity|null Найденная неактивная identity или null.
     * @throws \yii\base\InvalidConfigException Если модель домена настроена неверно.
     */
    public function findInactiveByEmail(?string $email): ?Identity
    {
        if ($email === null || $email === '') {
            return null;
        }

        /** @var Identity|null $identity */
        $identity = $this->findOne([
            User::ATTR_EMAIL => $email,
            User::ATTR_STATUS => Identity::STATUS_INACTIVE,
        ]);

        return $identity;
    }

    /**
     * Ищет неактивного пользователя по verification token.
     *
     * @param string $token Токен подтверждения email.
     * @return Identity|null Найденная identity или null.
     * @throws \yii\base\InvalidConfigException Если модель домена настроена неверно.
     */
    public function findInactiveByVerificationToken(string $token): ?Identity
    {
        /** @var Identity|null $identity */
        $identity = $this->findOne([
            User::ATTR_VERIFICATION => $token,
            User::ATTR_STATUS => Identity::STATUS_INACTIVE,
        ]);

        return $identity;
    }

    /**
     * Ищет пользователя по токену сброса пароля.
     *
     * @param string $token Токен сброса пароля.
     * @return Identity|null Найденная identity или null.
     * @throws \yii\base\InvalidConfigException Если модель домена настроена неверно.
     */
    public function findByPasswordResetToken(string $token): ?Identity
    {
        /** @var Identity|null $identity */
        $identity = $this->findOne([
            User::ATTR_PASSWORD_RESET => $token,
        ]);

        return $identity;
    }
}
