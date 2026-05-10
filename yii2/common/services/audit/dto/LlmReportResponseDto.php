<?php declare(strict_types=1);

namespace yii2\common\services\audit\dto;

/**
 * DTO ответа LLM-провайдера для отчёта.
 *
 * @package yii2\common\services\audit\dto
 */
final class LlmReportResponseDto
{
    /**
     * Создаёт DTO ответа отчёта.
     *
     * @param string $summary Краткое резюме для владельца.
     * @param array $tasks Список задач отчёта.
     * @param string $model Использованная модель.
     * @param string $promptVersion Версия prompt.
     * @param int|null $inputTokens Входные токены.
     * @param int|null $outputTokens Выходные токены.
     * @return void
     */
    public function __construct(
        public readonly string $summary,
        public readonly array $tasks,
        public readonly string $model,
        public readonly string $promptVersion,
        public readonly ?int $inputTokens = null,
        public readonly ?int $outputTokens = null,
    ) {
    }
}
