<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

/**
 * Контракт HTTP transport для OpenAI-compatible LLM provider.
 *
 * @package yii2\common\services\audit\llm
 */
interface LlmHttpTransportInterface
{
    /**
     * Выполняет POST JSON-запрос.
     *
     * @param string $url Endpoint URL.
     * @param array $payload JSON payload.
     * @param array $headers HTTP headers.
     * @param int $timeout Timeout в секундах.
     * @return LlmHttpResponse HTTP-ответ.
     * @throws LlmClientException При транспортной ошибке.
     */
    public function postJson(string $url, array $payload, array $headers, int $timeout): LlmHttpResponse;
}
