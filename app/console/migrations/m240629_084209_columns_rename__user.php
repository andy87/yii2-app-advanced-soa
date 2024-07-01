<?php

use andy87\yii2\architect\UpdateTable;

/**
 * Class m240629_084209_columns_rename__user
 */
class m240629_084209_columns_rename__user extends UpdateTable
{
    /** @var string Название таблицы */
    protected string $tableName = 'user';



    /** @var array Список колонок для переименования */
    public array $columnListRename = [
        'parent_id' => 'referal_id',
    ];
}
