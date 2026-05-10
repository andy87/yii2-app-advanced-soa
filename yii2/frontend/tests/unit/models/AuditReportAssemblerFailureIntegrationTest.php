<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use Codeception\Test\Unit;
use Yii;
use yii\db\Connection;
use yii\db\Exception as DbException;
use yii2\common\models\audit\AuditOrder;
use yii2\common\models\audit\AuditRun;
use yii2\common\models\audit\Domain;
use yii2\common\models\audit\Finding;
use yii2\common\models\audit\LlmCallLog;
use yii2\common\models\audit\Report;
use yii2\common\models\Identity;
use yii2\common\services\audit\AuditRunnerService;
use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\dto\LlmReportResponseDto;
use yii2\common\services\audit\llm\LlmClientException;
use yii2\common\services\audit\llm\LlmClientInterface;
use yii2\common\services\audit\llm\LlmClientMetadataInterface;
use yii2\common\services\audit\report\ReportAssembler;

/**
 * Integration-тест failed LLM path: ReportAssembler пишет failed log, runner переводит AuditRun в failed.
 *
 * @package yii2\frontend\tests\unit\models
 */
final class AuditReportAssemblerFailureIntegrationTest extends Unit
{
    private ?Connection $originalDb = null;
    private ?int $userId = null;
    private ?int $domainId = null;
    private ?int $orderId = null;
    private ?int $runId = null;

    /**
     * Поднимает изолированную in-memory SQLite DB для integration-теста.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('Для self-contained integration-теста нужен pdo_sqlite.');
        }

        $this->originalDb = Yii::$app->db;
        Yii::$app->set('db', new Connection(['dsn' => 'sqlite::memory:']));
        Yii::$app->db->open();
        $this->createSqliteSchema();
    }

    /**
     * Проверяет failed LLM log и статус AuditRun при HTTP 429 без сохранения сырого response.
     *
     * @return void
     * @throws \Throwable При неожиданной ошибке ActiveRecord/DB.
     */
    public function testFailedLlmCallCreatesFailedLogAndMarksRunFailed(): void
    {
        $run = $this->createAuditRunWithFinding();
        $runner = new AuditRunnerService(
            reportAssembler: new ReportAssembler(new FailingLlmClientForReportAssemblerIntegrationTest()),
        );

        try {
            $runner->generateReport($run);
            $this->fail('Expected LlmClientException was not thrown.');
        } catch (LlmClientException $e) {
            $this->assertSame(429, $e->getCode());
        }

        $run->refresh();
        $log = LlmCallLog::find()
            ->where(['audit_run_id' => $run->id, 'status' => LlmCallLog::STATUS_FAILED])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $this->assertSame(AuditRun::STATUS_FAILED, $run->status);
        $this->assertSame('LLM provider HTTP 429: RAW_RESPONSE_SECRET', $run->error_message);
        $this->assertInstanceOf(LlmCallLog::class, $log);
        $this->assertSame('fake-provider', $log->provider);
        $this->assertSame('fake-model', $log->model);
        $this->assertSame('fake-prompt-v1', $log->prompt_version);
        $this->assertSame(429, (int)$log->http_status);
        $this->assertSame(LlmCallLog::STATUS_FAILED, $log->status);
        $this->assertNotEmpty($log->request_hash);
        $this->assertNull($log->response_hash);
        $this->assertStringNotContainsString('RAW_RESPONSE_SECRET', (string)$log->error_message);
        $this->assertSame(0, (int)Report::find()->where(['audit_run_id' => $run->id])->count());
    }

    /**
     * Очищает созданные тестовые записи.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        if ($this->originalDb !== null) {
            Yii::$app->db->close();
            Yii::$app->set('db', $this->originalDb);
        }

        parent::tearDown();
    }

    /**
     * Создаёт минимальную SQLite schema для audit ActiveRecord integration.
     *
     * @return void
     * @throws DbException При ошибке создания таблиц.
     */
    private function createSqliteSchema(): void
    {
        $db = Yii::$app->db;

        $db->createCommand()->createTable('{{%user}}', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'username' => 'VARCHAR(255) NOT NULL',
            'auth_key' => 'VARCHAR(32) NOT NULL',
            'password_hash' => 'VARCHAR(255) NOT NULL',
            'password_reset_token' => 'VARCHAR(255) NULL',
            'email' => 'VARCHAR(255) NOT NULL',
            'status' => 'INTEGER NOT NULL',
            'role' => 'VARCHAR(32) NOT NULL',
            'name' => 'VARCHAR(255) NULL',
            'company_name' => 'VARCHAR(255) NULL',
            'verification_token' => 'VARCHAR(255) NULL',
            'created_at' => 'INTEGER NOT NULL',
            'updated_at' => 'INTEGER NOT NULL',
        ])->execute();

        $db->createCommand()->createTable('{{%domains}}', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'user_id' => 'INTEGER NOT NULL',
            'host' => 'VARCHAR(255) NOT NULL',
            'normalized_url' => 'VARCHAR(2048) NOT NULL',
            'status' => 'VARCHAR(32) NOT NULL',
            'created_at' => 'TEXT NULL',
            'updated_at' => 'TEXT NULL',
        ])->execute();

        $db->createCommand()->createTable('{{%audit_orders}}', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'user_id' => 'INTEGER NOT NULL',
            'domain_id' => 'INTEGER NOT NULL',
            'tariff' => 'VARCHAR(32) NOT NULL',
            'payment_status' => 'VARCHAR(32) NOT NULL',
            'workflow_status' => 'VARCHAR(32) NOT NULL',
            'page_limit' => 'INTEGER NOT NULL',
            'notes' => 'TEXT NULL',
            'created_at' => 'TEXT NULL',
            'updated_at' => 'TEXT NULL',
        ])->execute();

        $db->createCommand()->createTable('{{%audit_runs}}', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'order_id' => 'INTEGER NOT NULL',
            'status' => 'VARCHAR(32) NOT NULL',
            'started_at' => 'TEXT NULL',
            'finished_at' => 'TEXT NULL',
            'page_limit' => 'INTEGER NOT NULL',
            'pages_scanned' => 'INTEGER NOT NULL DEFAULT 0',
            'error_message' => 'TEXT NULL',
            'crawler_config_json' => 'TEXT NOT NULL DEFAULT "{}"',
            'created_at' => 'TEXT NULL',
            'updated_at' => 'TEXT NULL',
        ])->execute();

        $db->createCommand()->createTable('{{%findings}}', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'audit_run_id' => 'INTEGER NOT NULL',
            'page_id' => 'INTEGER NULL',
            'type' => 'VARCHAR(64) NOT NULL',
            'severity' => 'VARCHAR(32) NOT NULL',
            'title' => 'TEXT NOT NULL',
            'description' => 'TEXT NOT NULL',
            'evidence_json' => 'TEXT NOT NULL DEFAULT "{}"',
            'recommendation' => 'TEXT NULL',
            'is_false_positive' => 'INTEGER NOT NULL DEFAULT 0',
            'created_at' => 'TEXT NULL',
            'updated_at' => 'TEXT NULL',
        ])->execute();

        $db->createCommand()->createTable('{{%reports}}', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'audit_run_id' => 'INTEGER NOT NULL',
            'status' => 'VARCHAR(32) NOT NULL',
            'html_path' => 'TEXT NULL',
            'pdf_path' => 'TEXT NULL',
            'summary_json' => 'TEXT NOT NULL DEFAULT "{}"',
            'llm_model' => 'VARCHAR(128) NULL',
            'prompt_version' => 'VARCHAR(64) NULL',
            'approved_by_admin_id' => 'INTEGER NULL',
            'approved_at' => 'TEXT NULL',
            'created_at' => 'TEXT NULL',
            'updated_at' => 'TEXT NULL',
        ])->execute();

        $db->createCommand()->createTable('{{%llm_call_logs}}', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'audit_run_id' => 'INTEGER NULL',
            'report_id' => 'INTEGER NULL',
            'provider' => 'VARCHAR(64) NOT NULL',
            'model' => 'VARCHAR(128) NOT NULL',
            'prompt_version' => 'VARCHAR(64) NOT NULL',
            'request_hash' => 'VARCHAR(128) NOT NULL',
            'response_hash' => 'VARCHAR(128) NULL',
            'http_status' => 'INTEGER NULL',
            'input_tokens' => 'INTEGER NULL',
            'output_tokens' => 'INTEGER NULL',
            'status' => 'VARCHAR(32) NOT NULL',
            'error_message' => 'TEXT NULL',
            'created_at' => 'TEXT NULL',
        ])->execute();

        $db->schema->refresh();
    }

    /**
     * Создаёт AuditRun с одним deterministic finding и evidence.
     *
     * @return AuditRun Созданный запуск аудита.
     * @throws \RuntimeException Если запись не сохранена.
     */
    private function createAuditRunWithFinding(): AuditRun
    {
        $this->userId = $this->insertUser();

        $domain = new Domain([
            'user_id' => $this->userId,
            'host' => 'example.ru',
            'normalized_url' => 'https://example.ru/',
            'status' => Domain::STATUS_ACTIVE,
        ]);
        $this->saveOrFail($domain);
        $this->domainId = (int)$domain->id;

        $order = new AuditOrder([
            'user_id' => $this->userId,
            'domain_id' => $domain->id,
            'tariff' => AuditOrder::TARIFF_EXPRESS,
            'payment_status' => AuditOrder::PAYMENT_PAID,
            'workflow_status' => AuditOrder::WORKFLOW_RUNNING,
            'page_limit' => 1,
        ]);
        $this->saveOrFail($order);
        $this->orderId = (int)$order->id;

        $run = new AuditRun([
            'order_id' => $order->id,
            'status' => AuditRun::STATUS_CHECKING,
            'page_limit' => 1,
            'pages_scanned' => 1,
            'crawler_config_json' => ['maxDepth' => 1],
        ]);
        $this->saveOrFail($run);
        $this->runId = (int)$run->id;

        $finding = new Finding([
            'audit_run_id' => $run->id,
            'type' => 'title_missing',
            'severity' => Finding::SEVERITY_CRITICAL,
            'title' => 'Отсутствует title',
            'description' => 'На странице отсутствует title.',
            'recommendation' => 'Добавить title.',
            'evidence_json' => ['url' => 'https://example.ru/'],
        ]);
        $this->saveOrFail($finding);

        return $run;
    }

    /**
     * Создаёт пользователя с учётом фактических колонок таблицы user.
     *
     * @return int Идентификатор пользователя.
     * @throws DbException При ошибке вставки.
     */
    private function insertUser(): int
    {
        $suffix = uniqid('llm_', true);
        $row = [
            'username' => 'llm_' . $suffix,
            'auth_key' => str_repeat('a', 32),
            'password_hash' => 'test-hash',
            'email' => $suffix . '@example.test',
            'status' => Identity::STATUS_ACTIVE,
            'role' => Identity::ROLE_CLIENT,
            'name' => 'LLM test',
            'company_name' => 'LLM test',
            'verification_token' => null,
            'password_reset_token' => null,
            'created_at' => time(),
            'updated_at' => time(),
        ];

        Yii::$app->db->createCommand()->insert('{{%user}}', $row)->execute();

        return (int)Yii::$app->db->getLastInsertID();
    }

    /**
     * Сохраняет ActiveRecord или бросает понятную ошибку.
     *
     * @param \yii\db\ActiveRecord $model Модель.
     * @return void
     * @throws \RuntimeException Если модель не сохранена.
     */
    private function saveOrFail(\yii\db\ActiveRecord $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Не удалось сохранить ' . $model::class . ': ' . json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

}

/**
 * Fake LLM provider, который имитирует HTTP 429 с сырой строкой response в exception.
 *
 * @package yii2\frontend\tests\unit\models
 */
final class FailingLlmClientForReportAssemblerIntegrationTest implements LlmClientInterface, LlmClientMetadataInterface
{
    /**
     * Всегда падает как rate limit provider.
     *
     * @param LlmReportRequestDto $request Нормализованный request.
     * @return LlmReportResponseDto Не возвращается.
     * @throws LlmClientException Всегда HTTP 429.
     */
    public function generateAuditReport(LlmReportRequestDto $request): LlmReportResponseDto
    {
        throw new LlmClientException('LLM provider HTTP 429: RAW_RESPONSE_SECRET', 429);
    }

    /**
     * Возвращает fake provider name.
     *
     * @return string Provider name.
     */
    public function providerName(): string
    {
        return 'fake-provider';
    }

    /**
     * Возвращает fake model name.
     *
     * @return string Model name.
     */
    public function modelName(): string
    {
        return 'fake-model';
    }

    /**
     * Возвращает fake prompt version.
     *
     * @return string Prompt version.
     */
    public function promptVersion(): string
    {
        return 'fake-prompt-v1';
    }
}
