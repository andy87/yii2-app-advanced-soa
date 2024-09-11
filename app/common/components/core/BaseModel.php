<?php declare(strict_types=1);

namespace app\common\components\core;

use yii\db\ActiveRecord;

/**
 * < Common > `BaseModel`
 *
 * @package app\common\components\core
 */
abstract class BaseModel extends ActiveRecord
{
    public const ATTR_ID = 'id';
    public const ATTR_CREATED_AT = 'created_at';
    public const ATTR_UPDATED_AT = 'updated_at';
}