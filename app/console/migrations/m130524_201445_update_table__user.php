<?php declare(strict_types=1);

use andy87\yii2\architect\UpdateTable;
use app\common\models\sources\User;

/**
 * < Common > `m130524_201445_update_table__user`
 *
 * @package app\console\migrations
 *
 * @tag #console #migrations #user #verification #token
 */
class m130524_201445_update_table__user extends UpdateTable
{
    /** @var int Сценарий */
    public int $scenario = self::SCENARIO_UPDATE;

    /** @var string  */
    public string $tableName = '{{%user}}';

    /**
     * @return array
     */
    public function columnsListAdd(): array
    {
        return [
            User::ATTR_VERIFICATION => $this->string()->defaultValue(null)
        ];
    }
}
