<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

/**
 * DTO HTTP-ответа LLM transport.
 *
 * @package yii2\common\services\audit\llm
 */
final class LlmHttpResponse
{
    /**
     * Создаёт DTO HTTP-ответа.
     *
     * @param int $statusCode HTTP status code.
     * @param string $body Тело ответа provider.
     * @return void
     */
    public function __construct(
        public readonly int $statusCode,
        public readonly string $body,
    ) {
    }
}
