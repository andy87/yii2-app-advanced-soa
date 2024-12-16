<?php declare(strict_types=1);

namespace yii2\backend\components\dataProviders\items;

use yii\db\{Connection, QueryInterface};
use yii2\backend\components\dataProviders\parents\BackendActiveDataProvide;

/**
 * < Backend > Проводник к данным для модели `PascalCase` в окружении `backend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\backend\components\dataproviders\items
 *
 * @tag: #boilerplate #backend #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends BackendActiveDataProvide
{
    // {{Boilerplate}}
}