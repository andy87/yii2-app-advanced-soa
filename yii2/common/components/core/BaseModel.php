<?php declare(strict_types=1);

namespace yii2\common\components\core;

use yii\db\ActiveRecord;

/**
 * < Common > `BaseModel`
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 *
 * @package app\common\components\core
 */
abstract class BaseModel extends ActiveRecord
{
    public const ATTR_ID = 'id';
    public const ATTR_CREATED_AT = 'created_at';
    public const ATTR_UPDATED_AT = 'updated_at';
}