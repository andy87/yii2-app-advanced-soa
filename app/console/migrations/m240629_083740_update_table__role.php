<?php

use andy87\yii2\architect\UpdateTable;

/**
 * Class m240629_083740_update_table__role
 */
class m240629_083740_update_table__role extends UpdateTable
{
    /** @var string Название таблицы */
    protected string $tableName = 'role';




    /**
     * {@inheritdoc}
     */
    public function columnsListAdd(): array
    {
        return [
            'priority' => $this->integer()->defaultValue(1)->after('name')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function columnsListEdit(): array
    {
        return [
            'name' => $this->string(64)->notNull()->unique(),
        ];
    }


    /**
    * {@inheritdoc}
    */
    public function rollBackColumns(): array
    {
        return [
            'name' => $this->string(64)->notNull(),
        ];
    }
}
