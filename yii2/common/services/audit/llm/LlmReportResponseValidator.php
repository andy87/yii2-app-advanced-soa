<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

use yii2\common\models\audit\Finding;
use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\dto\LlmReportResponseDto;

/**
 * Валидирует JSON-ответ LLM по MVP-схеме и запрещает задачи без finding/evidence.
 *
 * @package yii2\common\services\audit\llm
 */
final class LlmReportResponseValidator
{
    /**
     * Возвращает JSON schema, которую должен соблюдать LLM provider.
     *
     * @return array JSON schema ответа отчёта.
     */
    public function schema(): array
    {
        return [
            'type' => 'object',
            'required' => ['summary', 'tasks'],
            'additionalProperties' => false,
            'properties' => [
                'summary' => ['type' => 'string', 'minLength' => 1],
                'tasks' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => [
                            'findingId',
                            'priority',
                            'title',
                            'technicalDescription',
                            'businessReason',
                            'suggestedAction',
                            'evidence',
                        ],
                        'additionalProperties' => false,
                        'properties' => [
                            'findingId' => ['type' => 'integer'],
                            'priority' => ['type' => 'string', 'enum' => [
                                Finding::SEVERITY_CRITICAL,
                                Finding::SEVERITY_MEDIUM,
                                Finding::SEVERITY_LOW,
                            ]],
                            'title' => ['type' => 'string', 'minLength' => 1],
                            'technicalDescription' => ['type' => 'string', 'minLength' => 1],
                            'businessReason' => ['type' => 'string', 'minLength' => 1],
                            'suggestedAction' => ['type' => 'string', 'minLength' => 1],
                            'evidence' => ['type' => 'object', 'minProperties' => 1],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Валидирует decoded JSON-ответ и возвращает DTO.
     *
     * @param array $data Decoded JSON-ответ provider.
     * @param LlmReportRequestDto $request Исходный запрос с findings.
     * @param string $model Название модели.
     * @param string $promptVersion Версия prompt.
     * @param int|null $inputTokens Входные токены.
     * @param int|null $outputTokens Выходные токены.
     * @return LlmReportResponseDto Валидированный DTO.
     * @throws LlmResponseValidationException Если структура ответа невалидна или задача не привязана к evidence.
     */
    public function validate(
        array $data,
        LlmReportRequestDto $request,
        string $model,
        string $promptVersion,
        ?int $inputTokens = null,
        ?int $outputTokens = null,
    ): LlmReportResponseDto {
        $this->assertString($data, 'summary');
        if (!isset($data['tasks']) || !is_array($data['tasks'])) {
            throw new LlmResponseValidationException('LLM response field `tasks` must be array.');
        }

        $findingMap = $this->findingMap($request);
        $tasks = [];

        foreach ($data['tasks'] as $index => $task) {
            if (!is_array($task)) {
                throw new LlmResponseValidationException("LLM task #{$index} must be object.");
            }

            $findingId = $this->assertFindingId($task, $index, $findingMap);
            $this->assertPriority($task, $index);
            $this->assertString($task, 'title', "task #{$index}");
            $this->assertString($task, 'technicalDescription', "task #{$index}");
            $this->assertString($task, 'businessReason', "task #{$index}");
            $this->assertString($task, 'suggestedAction', "task #{$index}");
            $evidence = $this->assertEvidence($task, $index);

            if (($findingMap[$findingId]['evidence'] ?? []) === []) {
                throw new LlmResponseValidationException("LLM task #{$index} references finding without source evidence.");
            }

            $tasks[] = [
                'findingId' => $findingId,
                'priority' => (string)$task['priority'],
                'title' => trim((string)$task['title']),
                'technicalDescription' => trim((string)$task['technicalDescription']),
                'businessReason' => trim((string)$task['businessReason']),
                'suggestedAction' => trim((string)$task['suggestedAction']),
                'evidence' => $evidence,
            ];
        }

        return new LlmReportResponseDto(
            trim((string)$data['summary']),
            $tasks,
            $model,
            $promptVersion,
            $inputTokens,
            $outputTokens,
        );
    }

    /**
     * Строит карту findings по id.
     *
     * @param LlmReportRequestDto $request Исходный запрос.
     * @return array<int, array> Карта findings.
     */
    private function findingMap(LlmReportRequestDto $request): array
    {
        $map = [];
        foreach ($request->findings as $finding) {
            if (isset($finding['id']) && is_int($finding['id'])) {
                $map[$finding['id']] = $finding;
            }
        }

        return $map;
    }

    /**
     * Проверяет обязательную строку.
     *
     * @param array $data Данные ответа.
     * @param string $field Имя поля.
     * @param string $context Контекст ошибки.
     * @return void
     * @throws LlmResponseValidationException Если поле отсутствует или пустое.
     */
    private function assertString(array $data, string $field, string $context = 'response'): void
    {
        if (!isset($data[$field]) || !is_string($data[$field]) || trim($data[$field]) === '') {
            throw new LlmResponseValidationException("LLM {$context} field `{$field}` must be non-empty string.");
        }
    }

    /**
     * Проверяет findingId задачи.
     *
     * @param array $task Данные задачи.
     * @param int $index Индекс задачи.
     * @param array $findingMap Карта допустимых findings.
     * @return int Валидный finding id.
     * @throws LlmResponseValidationException Если findingId отсутствует или не найден во входных findings.
     */
    private function assertFindingId(array $task, int $index, array $findingMap): int
    {
        if (!isset($task['findingId']) || filter_var($task['findingId'], FILTER_VALIDATE_INT) === false) {
            throw new LlmResponseValidationException("LLM task #{$index} must contain integer findingId.");
        }

        $findingId = (int)$task['findingId'];
        if (!isset($findingMap[$findingId])) {
            throw new LlmResponseValidationException("LLM task #{$index} references unknown findingId {$findingId}.");
        }

        return $findingId;
    }

    /**
     * Проверяет priority задачи.
     *
     * @param array $task Данные задачи.
     * @param int $index Индекс задачи.
     * @return void
     * @throws LlmResponseValidationException Если priority недопустим.
     */
    private function assertPriority(array $task, int $index): void
    {
        $allowed = [Finding::SEVERITY_CRITICAL, Finding::SEVERITY_MEDIUM, Finding::SEVERITY_LOW];
        if (!isset($task['priority']) || !in_array($task['priority'], $allowed, true)) {
            throw new LlmResponseValidationException("LLM task #{$index} has invalid priority.");
        }
    }

    /**
     * Проверяет evidence задачи.
     *
     * @param array $task Данные задачи.
     * @param int $index Индекс задачи.
     * @return array Evidence задачи.
     * @throws LlmResponseValidationException Если evidence отсутствует или пустой.
     */
    private function assertEvidence(array $task, int $index): array
    {
        if (!isset($task['evidence']) || !is_array($task['evidence']) || $task['evidence'] === []) {
            throw new LlmResponseValidationException("LLM task #{$index} must contain non-empty evidence.");
        }

        return $task['evidence'];
    }
}
