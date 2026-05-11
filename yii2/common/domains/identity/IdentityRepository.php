<?php declare(strict_types=1);

namespace yii2\common\domains\identity;

use andy87\yii2dnk\domain\BaseRepository;
use yii2\common\models\Identity;
use yii2\common\models\sources\User;

/**
 * DNK repository домена Identity.
 *
 * Инкапсулирует чтение активных пользователей и токенов Identity.
 */
class IdentityRepository extends BaseRepository
{
    protected const DOMAIN = IdentityDomain::class;

    /**
     * Ищет активную identity по username.
     *
     * @param string|null $username Имя пользователя.
     * @return Identity|null Найденная identity или null.
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
}
