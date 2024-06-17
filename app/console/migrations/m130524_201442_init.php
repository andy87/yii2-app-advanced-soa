<?php declare(strict_types=1);

use yii\db\Migration;
use yii\console\ExitCode;

/**
 * < Console > `m130524_201442_init`
 *
 * @package app\console\migrations
 *
 * @tag #console #migrations #init
 */
class m130524_201442_init extends Migration
{
    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function up(): int
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        return ExitCode::OK;
    }

    /**
     * @return int
     */
    public function down(): int
    {
        $this->dropTable('{{%user}}');

        return ExitCode::OK;
    }
}
