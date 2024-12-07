<?php

use andy87\yii2\architect\CreateTable;

/**
 * Class m241207_120513_create_table__pascal_case
 */
class m241207_120513_create_table__pascal_case extends CreateTable
{
    /** @var int Сценарий */
    public int $scenario = self::SCENARIO_CREATE;

    /** @var string Название таблицы */
    public string $tableName = 'pascal_case';



    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            'column' => $this->string(255)->null(),
            'count' => $this->integer()->defaultValue(0),
            'content' => $this->text()->null(),
        ];
    }
}
