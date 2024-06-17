<?php declare(strict_types=1);

use yii\db\Migration;
use yii\console\ExitCode;

/**
 * < Common > `m190124_110200_add_verification_token_column_to_user_table`
 *
 * @package app\console\migrations
 *
 * @tag #console #migrations #user #verification #token
 */
class m190124_110200_add_verification_token_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function up(): int
    {
        $this->addColumn('{{%user}}', 'verification_token', $this->string()->defaultValue(null));

        return ExitCode::OK;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function down(): int
    {
        $this->dropColumn('{{%user}}', 'verification_token');

        return ExitCode::OK;
    }
}
