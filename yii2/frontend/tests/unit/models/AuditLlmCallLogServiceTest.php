<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use Codeception\Test\Unit;
use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\dto\LlmReportResponseDto;
use yii2\common\services\audit\llm\LlmCallLogService;
use yii2\common\services\audit\llm\LlmClientException;
use yii2\common\services\audit\llm\LlmClientInterface;
use yii2\common\services\audit\llm\LlmClientMetadataInterface;

/**
 * Unit-тесты безопасных атрибутов failed LLM log без сырого prompt/API response.
 *
 * @package yii2\frontend\tests\unit\models
 */
final class AuditLlmCallLogServiceTest extends Unit
{
    /**
     * Проверяет атрибуты failed LLM log с HTTP status.
     *
     * @return void
     */
    public function testFailureAttributesContainSafeMetadataAndHttpStatus(): void
    {
        $attributes = (new LlmCallLogService())->failureAttributesByRunId(
            77,
            new MetadataLlmClientStub(),
            $this->request(),
            new LlmClientException('LLM provider HTTP 429: raw provider body must not be stored', 429),
        );

        verify($attributes['audit_run_id'])->equals(77);
        verify($attributes['provider'])->equals('stub-provider');
        verify($attributes['model'])->equals('stub-model');
        verify($attributes['prompt_version'])->equals('stub-v1');
        verify($attributes['http_status'])->equals(429);
        $this->assertNull($attributes['response_hash']);
        $this->assertNotEmpty($attributes['request_hash']);
        $this->assertStringContainsString('LLM provider HTTP 429', $attributes['error_message']);
    }

    /**
     * Проверяет, что non-HTTP exception не получает http_status.
     *
     * @return void
     */
    public function testFailureAttributesWithoutHttpStatusForValidationError(): void
    {
        $attributes = (new LlmCallLogService())->failureAttributesByRunId(
            77,
            new MetadataLlmClientStub(),
            $this->request(),
            new \RuntimeException('Invalid JSON envelope.'),
        );

        $this->assertNull($attributes['http_status']);
    }

    /**
     * Возвращает нормализованный request без сырого prompt.
     *
     * @return LlmReportRequestDto Тестовый request.
     */
    private function request(): LlmReportRequestDto
    {
        return new LlmReportRequestDto('example.ru', 1, [[
            'id' => 101,
            'type' => 'title_missing',
            'severity' => 'critical',
            'title' => 'Отсутствует title',
            'description' => 'На странице отсутствует title.',
            'recommendation' => 'Добавить title.',
            'evidence' => ['url' => 'https://example.ru/'],
        ]], ['dry-run']);
    }
}

/**
 * LLM client stub с metadata для тестов логирования.
 *
 * @package yii2\frontend\tests\unit\models
 */
final class MetadataLlmClientStub implements LlmClientInterface, LlmClientMetadataInterface
{
    /**
     * Stub-метод генерации отчёта.
     *
     * @param LlmReportRequestDto $request Нормализованный request.
     * @return LlmReportResponseDto Ответ не используется в тесте.
     * @throws LlmClientException Не используется в тесте.
     */
    public function generateAuditReport(LlmReportRequestDto $request): LlmReportResponseDto
    {
        throw new LlmClientException('Stub should not be called.');
    }

    /**
     * Возвращает имя provider.
     *
     * @return string Имя provider.
     */
    public function providerName(): string
    {
        return 'stub-provider';
    }

    /**
     * Возвращает имя модели.
     *
     * @return string Имя модели.
     */
    public function modelName(): string
    {
        return 'stub-model';
    }

    /**
     * Возвращает версию prompt.
     *
     * @return string Версия prompt.
     */
    public function promptVersion(): string
    {
        return 'stub-v1';
    }
}
