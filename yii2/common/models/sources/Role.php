<?php

namespace common\models\sources;

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
    public const string ATTR_KEY = 'key';
    public const string ATTR_NAME = 'name';
    public const string ATTR_HINT = 'hint';
    public const string ATTR_PRIORITY = 'priority';
}