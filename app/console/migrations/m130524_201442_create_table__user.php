<?php declare(strict_types=1);

use andy87\yii2\architect\CreateTable;

/**
 * < Console > `m130524_201442_create_table__user`
 *
 * @package app\console\migrations
 *
 * @tag #console #migrations #init
 */
class m130524_201442_create_table__user extends CreateTable
{
    /** @var string  */
    protected string $tableName = '{{%user}}';

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
        ];
    }
}
