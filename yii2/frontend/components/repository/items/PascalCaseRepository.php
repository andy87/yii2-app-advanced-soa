<?php declare(strict_types=1);

namespace yii2\frontend\components\repository\items;

use yii\db\{ActiveQuery, Connection};
use yii2\frontend\models\items\PascalCase;
use yii2\common\components\base\models\items\sources\SourceModel;

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
class PascalCaseRepository extends \yii2\common\components\repository\items\PascalCaseRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = PascalCase::class;
}