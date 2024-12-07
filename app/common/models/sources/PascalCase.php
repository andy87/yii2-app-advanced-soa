<?php

namespace app\common\models\sources;

use yii\db\ActiveRecord;

/**
 * < Common > `Role`
 *
 * @package app\common\models\sources
 *
 * @source php yii gii/model --tableName=role --modelClass=RoleSource --baseClass=app\common\components\core\BaseModel --ns=app\common\models\sources --generateLabelsFromComments --overwrite=1
 *
 */
class PascalCase extends ActiveRecord
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