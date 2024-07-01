<?php

use andy87\yii2\architect\CreateTable;

/**
 * Class m240629_083647_create_table__role
 */
class m240629_083647_create_table__role extends CreateTable
{
    /** @var string Название таблицы */
    protected string $tableName = 'role';


    /**
     * {@inheritdoc}
     */
    public function columns(): array
    {
        return [
            'key' => $this->string(32)->notNull()->unique(),
            'name' => $this->string(64)->notNull(),
        ];
    }
}
