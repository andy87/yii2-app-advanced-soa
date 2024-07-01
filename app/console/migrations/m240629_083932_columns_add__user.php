<?php

use andy87\yii2\architect\UpdateTable;

/**
 * Class m240629_083932_columns_add__user
 */
class m240629_083932_columns_add__user extends UpdateTable
{
    /** @var string Название таблицы */
    protected string $tableName = 'user';


    /** @var array Список внешних ключей */
    public array $foreignKeyList = [
        'role' => 'id',
    ];



    /**
     * {@inheritdoc}
     */
    public function columnsListAdd(): array
    {
        return [
            'role_id' => $this->integer()->null()->after('status'),
            'fio' => $this->string(255)->null()->after('email'),
            'parent_id' => $this->integer()->null()->after('status'),
        ];
    }
}
