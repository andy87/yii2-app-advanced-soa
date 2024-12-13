<?php

namespace yii2\common\models\sources;

/**
 * < Common > `Role`
 *
 * @package yii2\common\models\sources
 *
 * @source php yii gii/model --tableName=role --modelClass=RoleSource --baseClass=yii2\common\components\core\BaseModel --ns=yii2\common\models\sources --generateLabelsFromComments --overwrite=1
 *
 */
class Role extends RoleSource
{
    public const ATTR_KEY = 'key';
    public const ATTR_NAME = 'name';
    public const ATTR_HINT = 'hint';

    public const ATTR_PRIORITY = 'priority';

    public const USER = '@';
    public const GUEST = '?';
}