<?php declare(strict_types=1);

namespace common\dataProviders\items;

use yii\db\{Connection, QueryInterface};
use common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common > Родительский класс проводников данных: frontend/backend
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package yii2\common\components\dataproviders\items
 *
 * @tag: #boilerplate #common #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends SourceActiveDataProvider
{
    // {{Boilerplate}}
}