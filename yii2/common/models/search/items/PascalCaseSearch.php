<?php declare(strict_types=1);

namespace common\models\search\items;

use common\interfaces\models\SearchModelInterface;
use common\models\items\PascalCase;
use yii\db\ActiveQueryInterface;

/**
 * < Common > Модель с логикой поиска в `PascalCase` для окружения: common
 *
 * @package yii2\common\models\search\items
 *
 * @tag: #boilerplate #common #search #{{snake_case}}
 */
class PascalCaseSearch extends \common\models\items\PascalCase implements SearchModelInterface
{
    // {{Boilerplate}}
    public function search(array $params): ActiveQueryInterface
    {
        // TODO: Implement search() method.
    }
}