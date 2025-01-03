<?php declare(strict_types=1);

namespace common\components\base\models\items\sources;

use yii\db\ActiveRecord;
use common\interfaces\models\SourceModelInterface;

/**
 * < Common > Родительский класс для всех моделей базы данных
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @see SourceModel::SINGULAR
 * @see SourceModel::PLURAL
 *
 * @package yii2\common\components\base\models\items
 *
 * @tag: #abstract #common #model #base #source
 */
abstract class SourceModel extends ActiveRecord implements SourceModelInterface
{
    /** @var string Единственное число */
    public const string SINGULAR = 'Объект';

    /** @var string Множественное число */
    public const string PLURAL = 'Объекты';


    // {{Parent}}
}