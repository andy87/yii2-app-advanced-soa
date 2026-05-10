<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

/**
 * cURL transport для реальных OpenAI-compatible HTTP-запросов.
 *
 * @package yii2\common\services\audit\llm
 */
final class CurlLlmHttpTransport implements LlmHttpTransportInterface
{
    /**
     * Выполняет POST JSON-запрос через cURL.
     *
     * @param string $url Endpoint URL.
     * @param array $payload JSON payload.
     * @param array $headers HTTP headers.
     * @param int $timeout Timeout в секундах.
     * @return LlmHttpResponse HTTP-ответ provider.
     * @throws LlmClientException При ошибке кодирования payload или cURL.
     */
    public function postJson(string $url, array $payload, array $headers, int $timeout): LlmHttpResponse
    {
        $body = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (!is_string($body)) {
            throw new LlmClientException('Failed to encode LLM request payload.');
        }

        $ch = curl_init($url);
        if ($ch === false) {
            throw new LlmClientException('Failed to initialize LLM HTTP request.');
        }

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => min(10, $timeout),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $body,
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($error !== '') {
            throw new LlmClientException('LLM cURL error: ' . $error, 503);
        }

        if (!is_string($response)) {
            throw new LlmClientException('LLM provider returned empty response.', 503);
        }

        return new LlmHttpResponse($status, $response);
    }
}
