<?php declare(strict_types=1);

use andy87\yii2\architect\CreateTable;
use yii2\common\models\sources\User;

/**
 * < Console > `m130524_201442_create_table__user`
 *
 * @package yii2\console\migrations
 *
 * @tag #console #migrations #init
 */
class m130524_201442_create_table__user extends CreateTable
{
    protected const DATETIME = self::DATETIME_TIMESTAMP;

    /** @var int Сценарий */
    public int $scenario = self::SCENARIO_CREATE;

    /** @var string  */
    public string $tableName = '{{%user}}';

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            User::ATTR_USERNAME => $this->string()->notNull()->unique(),
            User::ATTR_AUTH_KEY => $this->string(32)->notNull(),
            User::ATTR_PASSWORD_HASH => $this->string()->notNull(),
            User::ATTR_PASSWORD_RESET => $this->string()->unique(),
            User::ATTR_EMAIL => $this->string()->notNull()->unique(),
            User::ATTR_STATUS => $this->smallInteger()->notNull()->defaultValue(10),
        ];
    }
}
