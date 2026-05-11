<?php declare(strict_types=1);

namespace yii2\common\domains\user;

use andy87\yii2dnk\domain\BaseDomain;
use yii2\common\models\sources\User;

/**
 * DNK registry домена User.
 *
 * Фиксирует пакетную структуру слоя User для дальнейшей миграции CRUD-сценариев.
 */
class UserDomain extends BaseDomain
{
    protected string $model = User::class;

    protected string $service = UserService::class;

    protected string $repository = UserRepository::class;

    protected string $producer = UserProducer::class;

    protected string $killer = UserKiller::class;

    protected string $handler = UserHandler::class;
}
