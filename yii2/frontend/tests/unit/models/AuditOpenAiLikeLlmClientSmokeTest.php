<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use Codeception\Test\Unit;
use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\llm\LlmClientException;
use yii2\common\services\audit\llm\LlmHttpResponse;
use yii2\common\services\audit\llm\LlmHttpTransportInterface;
use yii2\common\services\audit\llm\OpenAiLikeLlmClient;

/**
 * Smoke-тесты OpenAI-compatible LLM provider в dry-run режиме без внешнего API.
 *
 * @package yii2\frontend\tests\unit\models
 */
final class AuditOpenAiLikeLlmClientSmokeTest extends Unit
{
    /**
     * Проверяет успешный provider response без реального API key и сети.
     *
     * @return void
     * @throws LlmClientException При ошибке provider.
     */
    public function testSuccessfulDryRunResponse(): void
    {
        $transport = new DryRunLlmHttpTransport([
            new LlmHttpResponse(200, $this->providerEnvelope()),
        ]);

        $response = $this->client($transport)->generateAuditReport($this->request());

        verify($response->summary)->equals('Краткий отчёт сформирован.');
        verify($response->tasks[0]['findingId'])->equals(101);
        verify($transport->attempts)->equals(1);
        verify($transport->lastUrl)->equals('https://llm.test/v1/chat/completions');
    }

    /**
     * Проверяет retry/backoff после HTTP 429.
     *
     * @return void
     * @throws LlmClientException При ошибке provider.
     */
    public function testRetriesAfter429WithBackoff(): void
    {
        $delays = [];
        $transport = new DryRunLlmHttpTransport([
            new LlmHttpResponse(429, '{"error":"rate_limit"}'),
            new LlmHttpResponse(200, $this->providerEnvelope()),
        ]);

        $response = $this->client($transport, $delays)->generateAuditReport($this->request());

        verify(count($response->tasks))->equals(1);
        verify($transport->attempts)->equals(2);
        verify($delays)->equals([[25, 1]]);
    }

    /**
     * Проверяет retry/backoff после HTTP 500.
     *
     * @return void
     * @throws LlmClientException При ошибке provider.
     */
    public function testRetriesAfter500WithBackoff(): void
    {
        $delays = [];
        $transport = new DryRunLlmHttpTransport([
            new LlmHttpResponse(500, '{"error":"server"}'),
            new LlmHttpResponse(200, $this->providerEnvelope()),
        ]);

        $response = $this->client($transport, $delays)->generateAuditReport($this->request());

        verify($response->summary)->equals('Краткий отчёт сформирован.');
        verify($transport->attempts)->equals(2);
        verify($delays)->equals([[25, 1]]);
    }

    /**
     * Проверяет отклонение невалидного JSON envelope.
     *
     * @return void
     */
    public function testRejectsInvalidJsonEnvelope(): void
    {
        $transport = new DryRunLlmHttpTransport([
            new LlmHttpResponse(200, 'not-json'),
        ]);

        $this->expectException(LlmClientException::class);

        $this->client($transport)->generateAuditReport($this->request());
    }

    /**
     * Проверяет, что HTTP 400 не повторяется как retryable ошибка.
     *
     * @return void
     */
    public function testDoesNotRetry400(): void
    {
        $transport = new DryRunLlmHttpTransport([
            new LlmHttpResponse(400, '{"error":"bad_request"}'),
            new LlmHttpResponse(200, $this->providerEnvelope()),
        ]);

        $this->expectException(LlmClientException::class);

        try {
            $this->client($transport)->generateAuditReport($this->request());
        } finally {
            verify($transport->attempts)->equals(1);
        }
    }

    /**
     * Создаёт OpenAI-compatible client с dry-run transport.
     *
     * @param DryRunLlmHttpTransport $transport Dry-run transport.
     * @param array $delays Список backoff-задержек.
     * @return OpenAiLikeLlmClient Тестовый LLM-клиент.
     */
    private function client(DryRunLlmHttpTransport $transport, array &$delays = []): OpenAiLikeLlmClient
    {
        return new OpenAiLikeLlmClient(
            baseUrl: 'https://llm.test',
            apiKey: 'dry-run-key',
            model: 'dry-run-model',
            promptVersion: 'dry-run-v1',
            timeout: 3,
            maxRetries: 2,
            retryDelayMs: 25,
            transport: $transport,
            sleepCallback: static function (int $delayMs, int $attempt) use (&$delays): void {
                $delays[] = [$delayMs, $attempt];
            },
        );
    }

    /**
     * Возвращает тестовый LLM request с deterministic finding и evidence.
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
            'recommendation' => 'Добавить уникальный title.',
            'evidence' => ['url' => 'https://example.ru/'],
        ]], ['dry-run']);
    }

    /**
     * Возвращает валидный provider envelope chat completions.
     *
     * @return string JSON envelope.
     */
    private function providerEnvelope(): string
    {
        $content = [
            'summary' => 'Краткий отчёт сформирован.',
            'tasks' => [[
                'findingId' => 101,
                'priority' => 'critical',
                'title' => 'Добавить title',
                'technicalDescription' => 'На странице отсутствует title.',
                'businessReason' => 'Пользователю и поисковой системе сложнее понять содержание страницы.',
                'suggestedAction' => 'Добавить уникальный title.',
                'evidence' => ['url' => 'https://example.ru/'],
            ]],
        ];

        return json_encode([
            'choices' => [[
                'message' => [
                    'content' => json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ],
            ]],
            'usage' => [
                'prompt_tokens' => 100,
                'completion_tokens' => 50,
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
    }
}

/**
 * Dry-run HTTP transport для smoke-тестов LLM provider.
 *
 * @package yii2\frontend\tests\unit\models
 */
final class DryRunLlmHttpTransport implements LlmHttpTransportInterface
{
    public int $attempts = 0;
    public ?string $lastUrl = null;

    /**
     * Создаёт dry-run transport с очередью ответов.
     *
     * @param LlmHttpResponse[] $responses Очередь HTTP-ответов.
     * @return void
     */
    public function __construct(private array $responses)
    {
    }

    /**
     * Возвращает очередной dry-run HTTP-ответ без сетевого запроса.
     *
     * @param string $url Endpoint URL.
     * @param array $payload JSON payload.
     * @param array $headers HTTP headers.
     * @param int $timeout Timeout в секундах.
     * @return LlmHttpResponse HTTP-ответ из очереди.
     * @throws LlmClientException Если очередь ответов пуста.
     */
    public function postJson(string $url, array $payload, array $headers, int $timeout): LlmHttpResponse
    {
        $this->attempts++;
        $this->lastUrl = $url;

        if ($this->responses === []) {
            throw new LlmClientException('Dry-run LLM response queue is empty.', 503);
        }

        return array_shift($this->responses);
    }
}
