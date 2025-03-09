<?php declare(strict_types=1);

namespace yii2\common\services\db;

use yii2\common\{components\core\BaseRepository, models\sources\User, components\services\ActiveRecordService};
use yii\db\ActiveRecord;
use yii2\frontend\repositories\items\UserRepository;

/**
 * < Items > `UserService`
 *
 * @package yii2\common\services\items
 *
 * @property-read UserRepository $repository
 *
 * @method User|string getClassModel()
 * @method User createModel(array $attributes = [])
 * @method User addModel(array $attributes = [])
 *
 * @tag #common #service #items #user
 */
class UserService extends ActiveRecordService
{
    /** @var ActiveRecord|string  */
    protected ActiveRecord|string $modelClass = User::class;

    protected BaseRepository|string|null $repositoryClass = UserRepository::class;
}