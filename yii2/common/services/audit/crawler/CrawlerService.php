<?php declare(strict_types=1);

namespace yii2\common\services\audit\crawler;

use RuntimeException;
use yii2\common\services\audit\dto\CrawlPageDto;

/**
 * Ограниченный HTTP crawler для публичных страниц одного host.
 *
 * @package yii2\common\services\audit\crawler
 */
final class CrawlerService
{
    /**
     * Создаёт crawler.
     *
     * @param UrlNormalizer $normalizer Нормализатор URL.
     * @param DomainSafetyValidator $safetyValidator SSRF-защита.
     * @param HtmlParser $parser HTML-парсер.
     * @return void
     */
    public function __construct(
        private readonly UrlNormalizer $normalizer = new UrlNormalizer(),
        private readonly DomainSafetyValidator $safetyValidator = new DomainSafetyValidator(),
        private readonly HtmlParser $parser = new HtmlParser(),
    ) {
    }

    /**
     * Обходит сайт в пределах лимита страниц и глубины.
     *
     * @param string $startUrl Стартовый URL.
     * @param int $pageLimit Максимальное количество страниц.
     * @param int $maxDepth Максимальная глубина обхода.
     * @return CrawlPageDto[] Просканированные страницы.
     * @throws RuntimeException При критической ошибке стартового URL.
     */
    public function crawl(string $startUrl, int $pageLimit, int $maxDepth = 2): array
    {
        $startUrl = $this->normalizer->normalizeStartUrl($startUrl);
        $this->safetyValidator->assertSafeUrl($startUrl);
        $rootHost = $this->normalizer->host($startUrl);

        $queue = [[$startUrl, 0]];
        $seen = [];
        $pages = [];

        while ($queue !== [] && count($pages) < $pageLimit) {
            [$url, $depth] = array_shift($queue);
            if (isset($seen[$url]) || $depth > $maxDepth) {
                continue;
            }

            $seen[$url] = true;

            try {
                $page = $this->fetchPage($url);
            } catch (\Throwable $e) {
                $page = new CrawlPageDto($url, $url, null, null, null, null, null, null, [], [], [], []);
            }

            $pages[] = $page;

            if ($page->html === null || $depth >= $maxDepth) {
                continue;
            }

            foreach ($page->links as $link) {
                $linkUrl = $link['url'] ?? null;
                if (!is_string($linkUrl) || isset($seen[$linkUrl])) {
                    continue;
                }

                if ($this->normalizer->host($linkUrl) !== $rootHost) {
                    continue;
                }

                $queue[] = [$linkUrl, $depth + 1];
            }
        }

        return $pages;
    }

    /**
     * Загружает и парсит одну страницу.
     *
     * @param string $url URL страницы.
     * @return CrawlPageDto Данные страницы.
     * @throws RuntimeException При ошибке cURL или небезопасном redirect.
     */
    private function fetchPage(string $url): CrawlPageDto
    {
        $this->safetyValidator->assertSafeUrl($url);

        $timeout = (int)($_ENV['AUDIT_REQUEST_TIMEOUT'] ?? 8);
        $maxBytes = (int)($_ENV['AUDIT_MAX_RESPONSE_BYTES'] ?? 1048576);
        $userAgent = (string)($_ENV['AUDIT_USER_AGENT'] ?? 'SiteAuditorBot/0.1');

        $body = '';
        $ch = curl_init($url);
        if ($ch === false) {
            throw new RuntimeException('Не удалось инициализировать HTTP-запрос.');
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_USERAGENT => $userAgent,
            CURLOPT_HEADER => false,
            CURLOPT_WRITEFUNCTION => static function ($curl, string $chunk) use (&$body, $maxBytes): int {
                $body .= $chunk;
                if (strlen($body) > $maxBytes) {
                    return 0;
                }

                return strlen($chunk);
            },
        ]);

        curl_exec($ch);
        $error = curl_error($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        if ($error !== '') {
            throw new RuntimeException($error);
        }

        $contentType = is_string($contentType) ? $contentType : null;
        $isHtml = $contentType === null || str_contains(strtolower($contentType), 'text/html');
        $parsed = $isHtml ? $this->parser->parse($body, $url, $this->normalizer) : [];

        return new CrawlPageDto(
            $url,
            $url,
            $status > 0 ? $status : null,
            $contentType,
            $isHtml ? $body : null,
            $parsed['title'] ?? null,
            $parsed['description'] ?? null,
            $parsed['canonical'] ?? null,
            $parsed['h1'] ?? [],
            $parsed['links'] ?? [],
            $parsed['forms'] ?? [],
            $parsed['schema'] ?? [],
        );
    }
}
