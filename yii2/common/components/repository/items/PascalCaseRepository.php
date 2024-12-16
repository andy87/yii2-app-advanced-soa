<?php declare(strict_types=1);

namespace yii2\common\components\repository\items;

use yii\db\{ActiveQuery, Connection};
use yii2\common\models\items\PascalCase;
use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\repository\items\source\SourceRepository;

/**
 * < Common > Родительский класс для репозиториев: console/frontend/backend
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery findModel(array|string|int|null $criteria = null )
 * @method ActiveQuery findActive( array|string|int|null $criteria = null )
 * @method self setConnection( Connection $connection )
 * @method Connection|null getConnection()
 *
 * @package app\common\components\services\items
 *
 * @tag: #boilerplate #common #repository #{{snake_case}}
 */
class PascalCaseRepository extends SourceRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = \yii2\common\models\items\PascalCase::class;
}