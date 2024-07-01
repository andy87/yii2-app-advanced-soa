<?php

namespace app\common\models\sources;

/**
 * < Common > `Role`
 *
 * @package app\common\models\sources
 *
 * @source php yii gii/model --tableName=role --modelClass=RoleSource --baseClass=app\common\components\core\BaseModel --ns=app\common\models\sources --generateLabelsFromComments --overwrite=1
 *
 */
class Role extends RoleSource
{
    public const ATTR_KEY = 'key';
    public const ATTR_NAME = 'name';
    public const ATTR_HINT = 'hint';

    public const ATTR_PRIORITY = 'priority';
}