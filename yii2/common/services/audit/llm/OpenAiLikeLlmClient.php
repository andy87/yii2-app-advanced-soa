<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\dto\LlmReportResponseDto;

/**
 * OpenAI-compatible LLM-клиент для генерации JSON-черновика отчёта.
 *
 * @package yii2\common\services\audit\llm
 */
final class OpenAiLikeLlmClient implements LlmClientInterface, LlmClientMetadataInterface
{
    private const DEFAULT_CHAT_COMPLETIONS_PATH = '/v1/chat/completions';

    /**
     * Создаёт OpenAI-compatible LLM-клиент.
     *
     * @param string $baseUrl Base URL API, например `https://api.openai.com`.
     * @param string $apiKey API key provider.
     * @param string $model Название модели.
     * @param string $promptVersion Версия prompt.
     * @param int $timeout Timeout HTTP-запроса в секундах.
     * @param int $maxRetries Количество повторов после первой попытки.
     * @param int $retryDelayMs Базовая задержка backoff в миллисекундах.
     * @param LlmReportResponseValidator $validator Валидатор ответа.
     * @param LlmHttpTransportInterface $transport HTTP transport.
     * @param \Closure|null $sleepCallback Callback ожидания backoff для тестов.
     * @return void
     * @throws LlmClientException Если обязательные настройки отсутствуют.
     */
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey,
        private readonly string $model,
        private readonly string $promptVersion = 'audit-v1',
        private readonly int $timeout = 30,
        private readonly int $maxRetries = 2,
        private readonly int $retryDelayMs = 500,
        private readonly LlmReportResponseValidator $validator = new LlmReportResponseValidator(),
        private readonly LlmHttpTransportInterface $transport = new CurlLlmHttpTransport(),
        private readonly ?\Closure $sleepCallback = null,
    ) {
        if (trim($this->baseUrl) === '') {
            throw new LlmClientException('LLM_BASE_URL обязателен для openai-compatible provider.');
        }
        if (trim($this->apiKey) === '') {
            throw new LlmClientException('LLM_API_KEY обязателен для openai-compatible provider.');
        }
        if (trim($this->model) === '') {
            throw new LlmClientException('LLM_MODEL обязателен для openai-compatible provider.');
        }
    }

    /**
     * Генерирует структурированный черновик отчёта через chat completions API.
     *
     * @param LlmReportRequestDto $request Нормализованный запрос без сырого HTML.
     * @return LlmReportResponseDto Валидированный ответ provider.
     * @throws LlmClientException При сетевой ошибке, невалидном JSON или нарушении схемы.
     */
    public function generateAuditReport(LlmReportRequestDto $request): LlmReportResponseDto
    {
        $payload = [
            'model' => $this->model,
            'temperature' => 0.2,
            'response_format' => [
                'type' => 'json_schema',
                'json_schema' => [
                    'name' => 'site_audit_report',
                    'strict' => true,
                    'schema' => $this->validator->schema(),
                ],
            ],
            'messages' => [
                ['role' => 'system', 'content' => $this->systemPrompt()],
                ['role' => 'user', 'content' => $this->userPrompt($request)],
            ],
        ];

        $raw = $this->sendWithRetry($payload);
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            throw new LlmClientException('LLM provider returned invalid JSON envelope.');
        }

        $content = $decoded['choices'][0]['message']['content'] ?? null;
        if (!is_string($content) || trim($content) === '') {
            throw new LlmClientException('LLM provider response does not contain message content.');
        }

        $reportData = json_decode($content, true);
        if (!is_array($reportData)) {
            throw new LlmClientException('LLM message content is not valid JSON.');
        }

        $usage = $decoded['usage'] ?? [];

        return $this->validator->validate(
            $reportData,
            $request,
            $this->model,
            $this->promptVersion,
            isset($usage['prompt_tokens']) ? (int)$usage['prompt_tokens'] : null,
            isset($usage['completion_tokens']) ? (int)$usage['completion_tokens'] : null,
        );
    }

    /**
     * Выполняет HTTP-запрос с retry/backoff.
     *
     * @param array $payload Тело запроса.
     * @return string Сырой JSON-ответ provider.
     * @throws LlmClientException Если все попытки завершились ошибкой.
     */
    private function sendWithRetry(array $payload): string
    {
        $attempt = 0;
        $lastError = null;
        $maxAttempts = max(1, $this->maxRetries + 1);

        while ($attempt < $maxAttempts) {
            try {
                return $this->send($payload);
            } catch (LlmClientException $e) {
                $lastError = $e;
                $attempt++;
                if ($attempt >= $maxAttempts || !$this->isRetryable($e)) {
                    break;
                }

                $this->sleepBackoff($attempt);
            }
        }

        throw $lastError ?? new LlmClientException('LLM request failed.');
    }

    /**
     * Выполняет один HTTP-запрос к chat completions endpoint.
     *
     * @param array $payload Тело запроса.
     * @return string Сырой JSON-ответ.
     * @throws LlmClientException При HTTP/cURL ошибке.
     */
    private function send(array $payload): string
    {
        $url = rtrim($this->baseUrl, '/') . self::DEFAULT_CHAT_COMPLETIONS_PATH;
        $response = $this->transport->postJson(
            $url,
            $payload,
            [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
            ],
            $this->timeout,
        );

        if ($response->statusCode < 200 || $response->statusCode >= 300) {
            throw new LlmClientException("LLM provider HTTP {$response->statusCode}.", $response->statusCode);
        }

        return $response->body;
    }

    /**
     * Выполняет backoff sleep или тестовый callback.
     *
     * @param int $attempt Номер повторной попытки.
     * @return void
     */
    private function sleepBackoff(int $attempt): void
    {
        $delayMs = $this->retryDelayMs * $attempt;

        if ($this->sleepCallback !== null) {
            ($this->sleepCallback)($delayMs, $attempt);
            return;
        }

        usleep($delayMs * 1000);
    }

    /**
     * Проверяет, можно ли повторить запрос.
     *
     * @param LlmClientException $exception Исключение запроса.
     * @return bool Можно ли повторить.
     */
    private function isRetryable(LlmClientException $exception): bool
    {
        $code = (int)$exception->getCode();

        return $code === 0 || $code === 408 || $code === 409 || $code === 429 || $code >= 500;
    }

    /**
     * Возвращает system prompt для JSON-отчёта.
     *
     * @return string System prompt.
     */
    private function systemPrompt(): string
    {
        return implode("\n", [
            'Ты формируешь черновик отчёта аудита сайта малого бизнеса.',
            'Используй только переданные deterministic findings.',
            'Не выдумывай проблемы, URL, причины и рекомендации.',
            'Каждая задача обязана ссылаться на существующий findingId и содержать evidence из этого finding.',
            'Не обещай рост трафика, продаж, заявок, юридическое соответствие или безопасность.',
            'Ответь только JSON-объектом по переданной JSON schema.',
        ]);
    }

    /**
     * Возвращает user prompt с нормализованными findings.
     *
     * @param LlmReportRequestDto $request Запрос отчёта.
     * @return string User prompt.
     */
    private function userPrompt(LlmReportRequestDto $request): string
    {
        return json_encode([
            'domain' => $request->domain,
            'pagesScanned' => $request->pagesScanned,
            'limitations' => $request->limitations,
            'findings' => $request->findings,
            'outputRules' => [
                'summary' => 'Краткое резюме на русском языке для владельца бизнеса.',
                'tasks' => 'Список задач только по provided findings.',
                'priority' => 'Один из critical, medium, low.',
                'evidence' => 'Непустой объект evidence, взятый из соответствующего finding.',
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
    }

    /**
     * Возвращает имя provider для логов.
     *
     * @return string Имя provider.
     */
    public function providerName(): string
    {
        return 'openai-compatible';
    }

    /**
     * Возвращает имя модели для логов.
     *
     * @return string Имя модели.
     */
    public function modelName(): string
    {
        return $this->model;
    }

    /**
     * Возвращает версию prompt для логов.
     *
     * @return string Версия prompt.
     */
    public function promptVersion(): string
    {
        return $this->promptVersion;
    }
}
