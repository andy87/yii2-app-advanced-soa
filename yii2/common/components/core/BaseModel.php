<?php declare(strict_types=1);

namespace yii2\common\components\core;

use yii\db\ActiveRecord;
use yii2\common\components\interfaces\core\ModelInterface;

/**
 * < Common > `BaseModel`
 *
 * @package yii2\common\components\core
 */
abstract class BaseModel extends ActiveRecord implements ModelInterface
{
    public const ATTR_ID = 'id';
    public const ATTR_CREATED_AT = 'created_at';
    public const ATTR_UPDATED_AT = 'updated_at';
}