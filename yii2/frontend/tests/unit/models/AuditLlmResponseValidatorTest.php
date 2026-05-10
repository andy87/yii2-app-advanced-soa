<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use Codeception\Test\Unit;
use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\llm\LlmReportResponseValidator;
use yii2\common\services\audit\llm\LlmResponseValidationException;

/**
 * Unit-тесты защиты LLM-отчёта от задач без finding/evidence.
 *
 * @package yii2\frontend\tests\unit\models
 */
final class AuditLlmResponseValidatorTest extends Unit
{
    /**
     * Проверяет валидный LLM-ответ с findingId и evidence.
     *
     * @return void
     * @throws LlmResponseValidationException Если валидный ответ ошибочно отклонён.
     */
    public function testAcceptsTaskWithFindingAndEvidence(): void
    {
        $response = (new LlmReportResponseValidator())->validate($this->validResponse(), $this->request(), 'test-model', 'test-v1');

        verify($response->tasks[0]['findingId'])->equals(101);
        verify($response->tasks[0]['evidence'])->equals(['url' => 'https://example.ru/']);
    }

    /**
     * Проверяет запрет задачи без findingId.
     *
     * @return void
     */
    public function testRejectsTaskWithoutFindingId(): void
    {
        $data = $this->validResponse();
        unset($data['tasks'][0]['findingId']);

        $this->expectException(LlmResponseValidationException::class);

        (new LlmReportResponseValidator())->validate($data, $this->request(), 'test-model', 'test-v1');
    }

    /**
     * Проверяет запрет задачи без evidence.
     *
     * @return void
     */
    public function testRejectsTaskWithoutEvidence(): void
    {
        $data = $this->validResponse();
        unset($data['tasks'][0]['evidence']);

        $this->expectException(LlmResponseValidationException::class);

        (new LlmReportResponseValidator())->validate($data, $this->request(), 'test-model', 'test-v1');
    }

    /**
     * Проверяет запрет задачи с неизвестным findingId.
     *
     * @return void
     */
    public function testRejectsUnknownFindingId(): void
    {
        $data = $this->validResponse();
        $data['tasks'][0]['findingId'] = 999;

        $this->expectException(LlmResponseValidationException::class);

        (new LlmReportResponseValidator())->validate($data, $this->request(), 'test-model', 'test-v1');
    }

    /**
     * Проверяет запрет задачи по finding без исходного evidence.
     *
     * @return void
     */
    public function testRejectsFindingWithoutSourceEvidence(): void
    {
        $request = new LlmReportRequestDto('example.ru', 1, [[
            'id' => 101,
            'type' => 'title_missing',
            'severity' => 'critical',
            'title' => 'Отсутствует title',
            'description' => 'Описание',
            'recommendation' => 'Добавить title',
            'evidence' => [],
        ]], []);

        $this->expectException(LlmResponseValidationException::class);

        (new LlmReportResponseValidator())->validate($this->validResponse(), $request, 'test-model', 'test-v1');
    }

    /**
     * Проверяет запрет evidence, которого нет в исходном finding.
     *
     * @return void
     */
    public function testRejectsInventedEvidenceForKnownFinding(): void
    {
        $data = $this->validResponse();
        $data['tasks'][0]['evidence'] = ['url' => 'https://evil.test/'];

        $this->expectException(LlmResponseValidationException::class);

        (new LlmReportResponseValidator())->validate($data, $this->request(), 'test-model', 'test-v1');
    }

    /**
     * Проверяет, что подмножество исходного evidence разрешено.
     *
     * @return void
     * @throws LlmResponseValidationException Если валидный evidence ошибочно отклонён.
     */
    public function testAcceptsEvidenceSubsetFromSourceFinding(): void
    {
        $request = new LlmReportRequestDto('example.ru', 1, [[
            'id' => 101,
            'type' => 'title_missing',
            'severity' => 'critical',
            'title' => 'Отсутствует title',
            'description' => 'Описание',
            'recommendation' => 'Добавить title',
            'evidence' => ['url' => 'https://example.ru/', 'title' => '', 'length' => 0],
        ]], []);
        $data = $this->validResponse();
        $data['tasks'][0]['evidence'] = ['url' => 'https://example.ru/'];

        $response = (new LlmReportResponseValidator())->validate($data, $request, 'test-model', 'test-v1');

        verify($response->tasks[0]['evidence'])->equals(['url' => 'https://example.ru/']);
    }

    /**
     * Возвращает исходный LLM request для тестов.
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
            'description' => 'Описание',
            'recommendation' => 'Добавить title',
            'evidence' => ['url' => 'https://example.ru/'],
        ]], []);
    }

    /**
     * Возвращает валидный LLM response для тестов.
     *
     * @return array Тестовый response.
     */
    private function validResponse(): array
    {
        return [
            'summary' => 'Найден критичный SEO finding.',
            'tasks' => [[
                'findingId' => 101,
                'priority' => 'critical',
                'title' => 'Добавить title',
                'technicalDescription' => 'У страницы отсутствует title.',
                'businessReason' => 'Пользователю и поисковой системе сложнее понять содержание страницы.',
                'suggestedAction' => 'Добавить уникальный title.',
                'evidence' => ['url' => 'https://example.ru/'],
            ]],
        ];
    }
}
