<?php declare(strict_types=1);

namespace frontend\repository\items;

use yii\db\{ActiveQuery, Connection};
use common\components\base\models\items\sources\SourceModel;
use frontend\models\items\PascalCase;

/**
 * < Frontend > service for `PascalCaseService`
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery findModel(array|string|int|null $criteria = null)
 * @method ActiveQuery findActive(array|string|int|null $criteria = null)
 * @method self setConnection(Connection $connection)
 * @method Connection|null getConnection()
 *
 * @package app\frontend\components\services\items
 *
 * @tag: #boilerplate #frontend #service #{{snake_case}}
 */
class PascalCaseRepository extends \common\repository\items\PascalCaseRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = PascalCase::class;
}