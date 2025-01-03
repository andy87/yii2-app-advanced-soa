<?php declare(strict_types=1);

namespace backend\repository\items;

use yii\db\Connection;
use yii\db\ActiveQuery;
use backend\models\items\PascalCase;
use common\components\base\models\items\sources\SourceModel;

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
 * @package yii2\backend\components\services\items
 *
 * @tag: #boilerplate #backend #service #{{snake_case}}
 */
class PascalCaseRepository extends \console\repository\items\PascalCaseRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = PascalCase::class;
}