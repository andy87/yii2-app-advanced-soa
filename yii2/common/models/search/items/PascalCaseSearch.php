<?php declare(strict_types=1);

namespace yii2\common\models\search\items;

use yii\db\ActiveQueryInterface;
use yii2\common\models\items\PascalCase;
use yii2\common\components\interfaces\models\SearchModelInterface;

/**
 * < Common > Модель с логикой поиска в `PascalCase` для окружения: common
 *
 * @package app\common\models\search\items
 *
 * @tag: #boilerplate #common #search #{{snake_case}}
 */
class PascalCaseSearch extends \yii2\common\models\items\PascalCase implements SearchModelInterface
{
    // {{Boilerplate}}
    public function search(array $params): ActiveQueryInterface
    {
        // TODO: Implement search() method.
    }
}