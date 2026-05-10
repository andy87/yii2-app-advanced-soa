<?php declare(strict_types=1);

use yii\db\Migration;

/**
 * Добавляет HTTP status в технические логи LLM-вызовов.
 *
 * @package yii2\console\migrations
 */
class m260510_000002_add_http_status_to_llm_call_logs extends Migration
{
    /**
     * Применяет миграцию.
     *
     * @return void
     * @throws Throwable При ошибке изменения таблицы.
     */
    public function safeUp(): void
    {
        $schema = $this->db->getTableSchema('{{%llm_call_logs}}', true);
        if ($schema !== null && isset($schema->columns['http_status'])) {
            return;
        }

        $this->addColumn('{{%llm_call_logs}}', 'http_status', $this->integer());
        $this->createIndex('idx_llm_call_logs_http_status', '{{%llm_call_logs}}', 'http_status');
    }

    /**
     * Откатывает миграцию.
     *
     * @return void
     * @throws Throwable При ошибке изменения таблицы.
     */
    public function safeDown(): void
    {
        $schema = $this->db->getTableSchema('{{%llm_call_logs}}', true);
        if ($schema === null || !isset($schema->columns['http_status'])) {
            return;
        }

        $this->dropIndex('idx_llm_call_logs_http_status', '{{%llm_call_logs}}');
        $this->dropColumn('{{%llm_call_logs}}', 'http_status');
    }
}
