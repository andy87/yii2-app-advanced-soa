<?php declare(strict_types=1);

namespace yii2\common\services\audit\dto;

/**
 * DTO нормализованных данных для генерации отчёта через LLM.
 *
 * @package yii2\common\services\audit\dto
 */
final class LlmReportRequestDto
{
    /**
     * Создаёт DTO запроса отчёта.
     *
     * @param string $domain Домен аудита.
     * @param int $pagesScanned Количество просканированных страниц.
     * @param array $findings Нормализованные findings без сырого HTML.
     * @param array $limitations Ограничения проверки.
     * @return void
     */
    public function __construct(
        public readonly string $domain,
        public readonly int $pagesScanned,
        public readonly array $findings,
        public readonly array $limitations,
    ) {
    }
}
