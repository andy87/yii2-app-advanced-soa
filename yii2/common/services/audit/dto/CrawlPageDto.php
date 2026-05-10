<?php declare(strict_types=1);

namespace yii2\common\services\audit\dto;

/**
 * DTO результата загрузки и разбора одной страницы.
 *
 * @package yii2\common\services\audit\dto
 */
final class CrawlPageDto
{
    /**
     * Создаёт DTO страницы crawler.
     *
     * @param string $url Исходный URL.
     * @param string $normalizedUrl Нормализованный URL.
     * @param int|null $httpStatus HTTP-статус.
     * @param string|null $contentType Content-Type ответа.
     * @param string|null $html HTML-фрагмент ответа.
     * @param string|null $title Title страницы.
     * @param string|null $description Meta description.
     * @param string|null $canonical Canonical URL.
     * @param array $h1 Список H1.
     * @param array $links Список ссылок.
     * @param array $forms Список форм.
     * @param array $schema Список structured data.
     * @return void
     */
    public function __construct(
        public readonly string $url,
        public readonly string $normalizedUrl,
        public readonly ?int $httpStatus,
        public readonly ?string $contentType,
        public readonly ?string $html,
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?string $canonical,
        public readonly array $h1,
        public readonly array $links,
        public readonly array $forms,
        public readonly array $schema,
    ) {
    }
}
