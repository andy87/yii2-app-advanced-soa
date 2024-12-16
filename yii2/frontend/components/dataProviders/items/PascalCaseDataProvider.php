<?php declare(strict_types=1);

namespace yii2\frontend\components\dataProviders\items;

use yii\db\{Connection, QueryInterface};
use yii2\console\components\dataProvider\parents\ConsoleActiveDataProvider;

/**
 * < Frontend > Проводник к данным для модели `PascalCase` в окружении `frontend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\frontend\components\dataproviders\items
 *
 * @tag: #boilerplate #frontend #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends ConsoleActiveDataProvider
{
    // {{Boilerplate}}
}