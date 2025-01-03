<?php declare(strict_types=1);

namespace console\dataProviders\parents;

use yii\db\Connection;
use yii\db\QueryInterface;
use common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Console > Родительский класс для провайдеров данных в окружении: `console`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package yii2\console\components\dataProviders\parents
 *
 * @tag: #abstract #console #dataProvider
 */
abstract class ConsoleActiveDataProvider extends SourceActiveDataProvider
{
    // {{Parent}}
}