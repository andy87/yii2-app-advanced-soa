<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

/**
 * Фабрика LLM-клиента по env-настройкам.
 *
 * @package yii2\common\services\audit\llm
 */
final class LlmClientFactory
{
    /**
     * Создаёт LLM-клиент для текущего окружения.
     *
     * @return LlmClientInterface LLM-клиент.
     * @throws LlmClientException Если provider неизвестен или обязательные настройки отсутствуют.
     */
    public function create(): LlmClientInterface
    {
        $provider = strtolower((string)($_ENV['LLM_PROVIDER'] ?? 'mock'));

        return match ($provider) {
            'mock' => new MockLlmClient(),
            'openai-compatible' => new OpenAiLikeLlmClient(
                baseUrl: (string)($_ENV['LLM_BASE_URL'] ?? ''),
                apiKey: (string)($_ENV['LLM_API_KEY'] ?? ''),
                model: (string)($_ENV['LLM_MODEL'] ?? ''),
                promptVersion: (string)($_ENV['LLM_PROMPT_VERSION'] ?? 'audit-v1'),
                timeout: (int)($_ENV['LLM_TIMEOUT'] ?? 30),
                maxRetries: (int)($_ENV['LLM_RETRIES'] ?? 2),
                retryDelayMs: (int)($_ENV['LLM_RETRY_DELAY_MS'] ?? 500),
            ),
            default => throw new LlmClientException("Неизвестный LLM_PROVIDER `{$provider}`."),
        };
    }
}
