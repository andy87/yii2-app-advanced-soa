<?php

use andy87\yii2\architect\UpdateTable;

/**
 * Class m240629_084226_columns_remove__user
 */
class m240629_084226_columns_remove__user extends UpdateTable
{
    /** @var string Название таблицы */
    protected string $tableName = 'user';

    /** @var array Список колонок для удаления */
    public array $columnListRemove = [
        'fio' => null,
    ];



    /**
     * {@inheritdoc}
     */
    public function rollBackColumns(): array
    {
        return [
            'fio' => $this->string(255)->null()->after('email'),
        ];
    }

}
