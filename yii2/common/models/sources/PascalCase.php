<?php

namespace yii2\common\models\sources;

use yii2\common\components\base\models\items\sources\SourceModel;

/**
 * < Common > `Role`
 *
 * @package app\common\models\sources
 *
 * @source php yii gii/model --tableName=role --modelClass=RoleSource --baseClass=app\common\components\core\BaseModel --ns=app\common\models\sources --generateLabelsFromComments --overwrite=1
 *
 */
class PascalCase extends SourceModel
{

    public static function tableName(): string
    {
        return 'pascal_case';
    }

    public function rules(): array
    {
        return [
            [['column'],'string'],
            [['count'],'integer'],
            [['content'],'string'],
            [['created_at', 'updated_at'],'safe'],
        ];
    }
}