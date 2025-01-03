<?php declare(strict_types=1);

namespace frontend\dataProviders\parents;

use yii\db\Connection;
use yii\db\QueryInterface;
use common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Frontend > Родительский класс для провайдеров данных в окружении: `frontend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package yii2\frontend\components\dataProviders\parents
 *
 * @tag: #abstract #frontend #dataProvider
 */
abstract class FrontendActiveDataProvider extends SourceActiveDataProvider
{
    // {{Parent}}
}