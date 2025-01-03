<?php declare(strict_types=1);

namespace frontend\dataProviders\items;

use console\dataProviders\parents\ConsoleActiveDataProvider;
use yii\db\{Connection, QueryInterface};

/**
 * < Frontend > Проводник к данным для модели `PascalCase` в окружении `frontend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package yii2\frontend\components\dataproviders\items
 *
 * @tag: #boilerplate #frontend #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends ConsoleActiveDataProvider
{
    // {{Boilerplate}}
}