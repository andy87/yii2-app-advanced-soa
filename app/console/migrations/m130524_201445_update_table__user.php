<?php declare(strict_types=1);

use andy87\yii2\architect\UpdateTable;

/**
 * < Common > `m130524_201445_update_table__user`
 *
 * @package app\console\migrations
 *
 * @tag #console #migrations #user #verification #token
 */
class m130524_201445_update_table__user extends UpdateTable
{
    /** @var string  */
    public string $tableName = '{{%user}}';

    /**
     * @return array
     */
    public function columnsListAdd(): array
    {
        return [
            'verification_token' => $this->string()->defaultValue(null)
        ];
    }
}
