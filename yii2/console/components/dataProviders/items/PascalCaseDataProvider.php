<?php declare(strict_types=1);

namespace yii2\console\components\dataProviders\items;

use yii\db\{Connection, QueryInterface};
use yii2\console\components\dataProvider\parents\ConsoleActiveDataProvider;

/**
 * < Console > Проводник к данным для модели `PascalCase` в окружении `console`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\console\components\dataproviders\items
 *
 * @tag: #boilerplate #console #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends ConsoleActiveDataProvider
{
    // {{Boilerplate}}
}