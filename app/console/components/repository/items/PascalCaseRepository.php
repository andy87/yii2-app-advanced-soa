<?php declare(strict_types=1);

namespace app\console\components\repository\items;

use yii\db\{ActiveQuery, Connection};
use app\console\models\items\PascalCase;
use app\common\components\base\models\items\sources\SourceModel;

/**
 * < Console > service for `PascalCaseService`
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery findModel(array|string|int|null $criteria = null)
 * @method ActiveQuery findActive(array|string|int|null $criteria = null)
 * @method self setConnection(Connection $connection)
 * @method Connection|null getConnection()
 *
 * @package app\console\components\services\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseRepository extends \app\common\components\repository\items\PascalCaseRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = PascalCase::class;
}