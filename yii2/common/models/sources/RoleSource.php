<?php

namespace yii2\common\models\sources;

/**
 * This is the model class for table "role".
 *
 * @property int $id ID
 * @property string $key Ключ
 * @property string $name Название
 * @property string|null $hint Описание
 * @property int $priority Приоритет
 * @property string|null $created_at Дата создания
 * @property string|null $updated_at Дата обновления
 */
class RoleSource extends \yii2\common\components\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['key', 'name'], 'required'],
            [['priority'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['key'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 64],
            [['hint'], 'string', 'max' => 255],
            [['key'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'key' => 'Ключ',
            'name' => 'Название',
            'hint' => 'Описание',
            'priority' => 'Приоритет',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
