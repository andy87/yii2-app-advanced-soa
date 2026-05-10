<?php declare(strict_types=1);

use yii\db\Migration;

/**
 * Создаёт таблицы MVP аудита сайтов и расширяет существующую таблицу пользователей.
 *
 * @package yii2\console\migrations
 */
class m260510_000001_create_audit_mvp_tables extends Migration
{
    /**
     * Применяет миграцию схемы аудита.
     *
     * @return void
     * @throws Throwable При ошибке создания таблиц или индексов.
     */
    public function safeUp(): void
    {
        $this->addUserProfileColumns();

        $this->createTable('{{%domains}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->integer()->notNull(),
            'host' => $this->string(255)->notNull(),
            'normalized_url' => $this->string(2048)->notNull(),
            'status' => $this->string(32)->notNull()->defaultValue('active'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_domains_user_id', '{{%domains}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_domains_user_id', '{{%domains}}', 'user_id');
        $this->createIndex('idx_domains_host', '{{%domains}}', 'host');

        $this->createTable('{{%audit_orders}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->integer()->notNull(),
            'domain_id' => $this->bigInteger()->notNull(),
            'tariff' => $this->string(32)->notNull(),
            'payment_status' => $this->string(32)->notNull()->defaultValue('unpaid'),
            'workflow_status' => $this->string(32)->notNull()->defaultValue('new'),
            'page_limit' => $this->integer()->notNull(),
            'notes' => $this->text(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_audit_orders_user_id', '{{%audit_orders}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_audit_orders_domain_id', '{{%audit_orders}}', 'domain_id', '{{%domains}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_audit_orders_user_id', '{{%audit_orders}}', 'user_id');
        $this->createIndex('idx_audit_orders_domain_id', '{{%audit_orders}}', 'domain_id');
        $this->createIndex('idx_audit_orders_workflow_status', '{{%audit_orders}}', 'workflow_status');
        $this->createIndex('idx_audit_orders_created_at', '{{%audit_orders}}', 'created_at');

        $this->createTable('{{%audit_runs}}', [
            'id' => $this->bigPrimaryKey(),
            'order_id' => $this->bigInteger()->notNull(),
            'status' => $this->string(32)->notNull(),
            'started_at' => $this->timestamp(),
            'finished_at' => $this->timestamp(),
            'page_limit' => $this->integer()->notNull(),
            'pages_scanned' => $this->integer()->notNull()->defaultValue(0),
            'error_message' => $this->text(),
            'crawler_config_json' => $this->jsonObjectDefinition(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_audit_runs_order_id', '{{%audit_runs}}', 'order_id', '{{%audit_orders}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_audit_runs_order_id', '{{%audit_runs}}', 'order_id');
        $this->createIndex('idx_audit_runs_status', '{{%audit_runs}}', 'status');
        $this->createIndex('idx_audit_runs_created_at', '{{%audit_runs}}', 'created_at');

        $this->createTable('{{%audit_pages}}', [
            'id' => $this->bigPrimaryKey(),
            'audit_run_id' => $this->bigInteger()->notNull(),
            'url' => $this->text()->notNull(),
            'normalized_url' => $this->text()->notNull(),
            'http_status' => $this->integer(),
            'content_type' => $this->string(255),
            'title' => $this->text(),
            'description' => $this->text(),
            'canonical' => $this->text(),
            'h1_json' => $this->jsonArrayDefinition(),
            'links_json' => $this->jsonArrayDefinition(),
            'forms_json' => $this->jsonArrayDefinition(),
            'schema_json' => $this->jsonArrayDefinition(),
            'fetched_at' => $this->timestamp(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_audit_pages_audit_run_id', '{{%audit_pages}}', 'audit_run_id', '{{%audit_runs}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_audit_pages_audit_run_id', '{{%audit_pages}}', 'audit_run_id');
        $this->createIndex('idx_audit_pages_http_status', '{{%audit_pages}}', 'http_status');

        $this->createTable('{{%findings}}', [
            'id' => $this->bigPrimaryKey(),
            'audit_run_id' => $this->bigInteger()->notNull(),
            'page_id' => $this->bigInteger(),
            'type' => $this->string(64)->notNull(),
            'severity' => $this->string(32)->notNull(),
            'title' => $this->text()->notNull(),
            'description' => $this->text()->notNull(),
            'evidence_json' => $this->jsonObjectDefinition(),
            'recommendation' => $this->text(),
            'is_false_positive' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_findings_audit_run_id', '{{%findings}}', 'audit_run_id', '{{%audit_runs}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_findings_page_id', '{{%findings}}', 'page_id', '{{%audit_pages}}', 'id', 'SET NULL', 'CASCADE');
        $this->createIndex('idx_findings_audit_run_id', '{{%findings}}', 'audit_run_id');
        $this->createIndex('idx_findings_page_id', '{{%findings}}', 'page_id');
        $this->createIndex('idx_findings_severity', '{{%findings}}', 'severity');
        $this->createIndex('idx_findings_created_at', '{{%findings}}', 'created_at');

        $this->createTable('{{%reports}}', [
            'id' => $this->bigPrimaryKey(),
            'audit_run_id' => $this->bigInteger()->notNull(),
            'status' => $this->string(32)->notNull(),
            'html_path' => $this->text(),
            'pdf_path' => $this->text(),
            'summary_json' => $this->jsonObjectDefinition(),
            'llm_model' => $this->string(128),
            'prompt_version' => $this->string(64),
            'approved_by_admin_id' => $this->integer(),
            'approved_at' => $this->timestamp(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_reports_audit_run_id', '{{%reports}}', 'audit_run_id', '{{%audit_runs}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_reports_approved_by_admin_id', '{{%reports}}', 'approved_by_admin_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->createIndex('idx_reports_audit_run_id', '{{%reports}}', 'audit_run_id', true);
        $this->createIndex('idx_reports_status', '{{%reports}}', 'status');
        $this->createIndex('idx_reports_created_at', '{{%reports}}', 'created_at');

        $this->createTable('{{%report_tasks}}', [
            'id' => $this->bigPrimaryKey(),
            'report_id' => $this->bigInteger()->notNull(),
            'finding_id' => $this->bigInteger(),
            'priority' => $this->string(32)->notNull(),
            'title' => $this->text()->notNull(),
            'technical_description' => $this->text()->notNull(),
            'business_reason' => $this->text(),
            'suggested_action' => $this->text()->notNull(),
            'status' => $this->string(32)->notNull()->defaultValue('open'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_report_tasks_report_id', '{{%report_tasks}}', 'report_id', '{{%reports}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_report_tasks_finding_id', '{{%report_tasks}}', 'finding_id', '{{%findings}}', 'id', 'SET NULL', 'CASCADE');
        $this->createIndex('idx_report_tasks_report_id', '{{%report_tasks}}', 'report_id');
        $this->createIndex('idx_report_tasks_finding_id', '{{%report_tasks}}', 'finding_id');
        $this->createIndex('idx_report_tasks_status', '{{%report_tasks}}', 'status');
        $this->createIndex('idx_report_tasks_created_at', '{{%report_tasks}}', 'created_at');

        $this->createTable('{{%prompt_versions}}', [
            'id' => $this->bigPrimaryKey(),
            'code' => $this->string(64)->notNull()->unique(),
            'system_prompt' => $this->text()->notNull(),
            'user_prompt_template' => $this->text()->notNull(),
            'status' => $this->string(32)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->createIndex('idx_prompt_versions_status', '{{%prompt_versions}}', 'status');
        $this->createIndex('idx_prompt_versions_created_at', '{{%prompt_versions}}', 'created_at');

        $this->createTable('{{%llm_call_logs}}', [
            'id' => $this->bigPrimaryKey(),
            'audit_run_id' => $this->bigInteger(),
            'report_id' => $this->bigInteger(),
            'provider' => $this->string(64)->notNull(),
            'model' => $this->string(128)->notNull(),
            'prompt_version' => $this->string(64)->notNull(),
            'request_hash' => $this->string(128)->notNull(),
            'response_hash' => $this->string(128),
            'http_status' => $this->integer(),
            'input_tokens' => $this->integer(),
            'output_tokens' => $this->integer(),
            'status' => $this->string(32)->notNull(),
            'error_message' => $this->text(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_llm_call_logs_audit_run_id', '{{%llm_call_logs}}', 'audit_run_id', '{{%audit_runs}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_llm_call_logs_report_id', '{{%llm_call_logs}}', 'report_id', '{{%reports}}', 'id', 'SET NULL', 'CASCADE');
        $this->createIndex('idx_llm_call_logs_audit_run_id', '{{%llm_call_logs}}', 'audit_run_id');
        $this->createIndex('idx_llm_call_logs_report_id', '{{%llm_call_logs}}', 'report_id');
        $this->createIndex('idx_llm_call_logs_http_status', '{{%llm_call_logs}}', 'http_status');
        $this->createIndex('idx_llm_call_logs_status', '{{%llm_call_logs}}', 'status');
        $this->createIndex('idx_llm_call_logs_created_at', '{{%llm_call_logs}}', 'created_at');
    }

    /**
     * Откатывает миграцию схемы аудита.
     *
     * @return void
     * @throws Throwable При ошибке удаления таблиц или колонок.
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%llm_call_logs}}');
        $this->dropTable('{{%prompt_versions}}');
        $this->dropTable('{{%report_tasks}}');
        $this->dropTable('{{%reports}}');
        $this->dropTable('{{%findings}}');
        $this->dropTable('{{%audit_pages}}');
        $this->dropTable('{{%audit_runs}}');
        $this->dropTable('{{%audit_orders}}');
        $this->dropTable('{{%domains}}');

        $this->dropUserProfileColumns();
    }

    /**
     * Добавляет недостающие профильные колонки пользователя.
     *
     * @return void
     * @throws Throwable При ошибке изменения таблицы пользователей.
     */
    private function addUserProfileColumns(): void
    {
        $schema = $this->db->getTableSchema('{{%user}}', true);
        if ($schema === null) {
            return;
        }

        if (!isset($schema->columns['role'])) {
            $this->addColumn('{{%user}}', 'role', $this->string(32)->notNull()->defaultValue('client'));
            $this->createIndex('idx_user_role', '{{%user}}', 'role');
        }

        if (!isset($schema->columns['name'])) {
            $this->addColumn('{{%user}}', 'name', $this->string(255));
        }

        if (!isset($schema->columns['company_name'])) {
            $this->addColumn('{{%user}}', 'company_name', $this->string(255));
        }
    }

    /**
     * Удаляет профильные колонки пользователя, если они существуют.
     *
     * @return void
     * @throws Throwable При ошибке изменения таблицы пользователей.
     */
    private function dropUserProfileColumns(): void
    {
        $schema = $this->db->getTableSchema('{{%user}}', true);
        if ($schema === null) {
            return;
        }

        if (isset($schema->columns['role'])) {
            $this->dropIndex('idx_user_role', '{{%user}}');
            $this->dropColumn('{{%user}}', 'role');
        }

        if (isset($schema->columns['name'])) {
            $this->dropColumn('{{%user}}', 'name');
        }

        if (isset($schema->columns['company_name'])) {
            $this->dropColumn('{{%user}}', 'company_name');
        }
    }

    /**
     * Возвращает определение JSON-объекта с PostgreSQL JSONB и fallback для других СУБД.
     *
     * @return string Определение колонки JSON-объекта.
     */
    private function jsonObjectDefinition(): string
    {
        return $this->db->driverName === 'pgsql'
            ? "jsonb NOT NULL DEFAULT '{}'::jsonb"
            : "json NOT NULL";
    }

    /**
     * Возвращает определение JSON-массива с PostgreSQL JSONB и fallback для других СУБД.
     *
     * @return string Определение колонки JSON-массива.
     */
    private function jsonArrayDefinition(): string
    {
        return $this->db->driverName === 'pgsql'
            ? "jsonb NOT NULL DEFAULT '[]'::jsonb"
            : "json NOT NULL";
    }
}
