<?php

use andy87\yii2\architect\CreateTable;
use app\common\models\sources\Role;

/**
 * Class m240629_083647_create_table__role
 */
class m240629_083647_create_table__role extends CreateTable
{
    /** @var int Сценарий */
    public int $scenario = self::SCENARIO_CREATE;

    /** @var string Название таблицы */
    public string $tableName = '{{%role}}';


    /**
     * {@inheritdoc}
     */
    public function columns(): array
    {
        return [
            Role::ATTR_KEY => $this->string(32)->notNull()->unique()->comment('Ключ'),
            Role::ATTR_NAME => $this->string(64)->notNull()->unique()->comment('Название'),
            Role::ATTR_HINT => $this->string(255)->null()->comment('Описание'),
            Role::ATTR_PRIORITY => $this->integer(5)->notNull()->defaultValue(1)->comment('Приоритет'),
        ];
    }
}
