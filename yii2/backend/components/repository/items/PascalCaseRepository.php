<?php declare(strict_types=1);

namespace yii2\backend\components\repository\items;

use yii\db\{ActiveQuery, Connection};
use yii2\backend\models\items\PascalCase;
use yii2\common\components\base\models\items\sources\SourceModel;

/**
 * < Backend > service for `PascalCaseService`
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery findModel(array|string|int|null $criteria = null)
 * @method ActiveQuery findActive(array|string|int|null $criteria = null)
 * @method self setConnection(Connection $connection)
 * @method Connection|null getConnection()
 *
 * @package app\backend\components\services\items
 *
 * @tag: #boilerplate #backend #service #{{snake_case}}
 */
class PascalCaseRepository extends \yii2\console\components\repository\items\PascalCaseRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = PascalCase::class;
}