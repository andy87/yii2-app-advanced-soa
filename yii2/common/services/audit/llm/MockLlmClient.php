<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\dto\LlmReportResponseDto;

/**
 * Mock LLM-клиент для MVP и локального Docker-запуска без внешнего API.
 *
 * @package yii2\common\services\audit\llm
 */
final class MockLlmClient implements LlmClientInterface, LlmClientMetadataInterface
{
    /**
     * Создаёт mock LLM-клиент.
     *
     * @param LlmReportResponseValidator $validator Валидатор структурированного ответа.
     * @return void
     */
    public function __construct(private readonly LlmReportResponseValidator $validator = new LlmReportResponseValidator())
    {
    }

    /**
     * Генерирует детерминированный черновик отчёта из findings.
     *
     * @param LlmReportRequestDto $request Нормализованный запрос.
     * @return LlmReportResponseDto Черновик отчёта.
     * @throws LlmClientException Не используется в mock-реализации.
     */
    public function generateAuditReport(LlmReportRequestDto $request): LlmReportResponseDto
    {
        $critical = 0;
        $medium = 0;
        $low = 0;
        $tasks = [];

        foreach ($request->findings as $finding) {
            $severity = (string)($finding['severity'] ?? 'low');
            if ($severity === 'critical') {
                $critical++;
            } elseif ($severity === 'medium') {
                $medium++;
            } else {
                $low++;
            }

            $tasks[] = [
                'findingId' => $finding['id'] ?? null,
                'priority' => $severity,
                'title' => $finding['title'] ?? 'Проверить проблему сайта',
                'technicalDescription' => $finding['description'] ?? '',
                'businessReason' => 'Проблема может ухудшать понятность страницы, индексируемость или путь пользователя к заявке. Эффект требует проверки после внедрения.',
                'suggestedAction' => $finding['recommendation'] ?? 'Проверить страницу и внести корректировку по evidence.',
                'evidence' => $finding['evidence'] ?? [],
            ];
        }

        $summary = sprintf(
            'Проверено страниц: %d. Найдено проблем: %d, критичных: %d, средних: %d, низких: %d. Отчёт основан на автоматических проверках и требует ручной проверки перед отправкой клиенту.',
            $request->pagesScanned,
            count($request->findings),
            $critical,
            $medium,
            $low,
        );

        return $this->validator->validate([
            'summary' => $summary,
            'tasks' => $tasks,
        ], $request, 'mock-llm', 'mock-v1');
    }

    /**
     * Возвращает имя mock provider.
     *
     * @return string Имя provider.
     */
    public function providerName(): string
    {
        return 'mock';
    }

    /**
     * Возвращает имя mock модели.
     *
     * @return string Имя модели.
     */
    public function modelName(): string
    {
        return 'mock-llm';
    }

    /**
     * Возвращает версию prompt mock provider.
     *
     * @return string Версия prompt.
     */
    public function promptVersion(): string
    {
        return 'mock-v1';
    }
}
