<?php declare(strict_types=1);

namespace backend\dataProviders\items;

use yii\db\Connection;
use yii\db\QueryInterface;
use backend\dataProviders\parents\BackendActiveDataProvide;

/**
 * < Backend > Проводник к данным для модели `PascalCase` в окружении `backend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package yii2\backend\components\dataproviders\items
 *
 * @tag: #boilerplate #backend #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends BackendActiveDataProvide
{
    // {{Boilerplate}}
}