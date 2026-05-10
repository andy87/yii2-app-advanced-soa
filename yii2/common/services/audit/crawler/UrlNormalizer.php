<?php declare(strict_types=1);

namespace yii2\common\services\audit\crawler;

use InvalidArgumentException;

/**
 * Нормализует входные URL и ссылки crawler без сетевых запросов.
 *
 * @package yii2\common\services\audit\crawler
 */
final class UrlNormalizer
{
    /**
     * Нормализует пользовательский URL до абсолютного HTTP(S)-адреса.
     *
     * @param string $url Введённый URL или домен.
     * @return string Нормализованный URL.
     * @throws InvalidArgumentException Если URL невалиден или использует неподдерживаемую схему.
     */
    public function normalizeStartUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            throw new InvalidArgumentException('URL не должен быть пустым.');
        }

        if (!preg_match('~^https?://~i', $url)) {
            $url = 'https://' . $url;
        }

        return $this->normalizeAbsoluteUrl($url);
    }

    /**
     * Нормализует абсолютный URL.
     *
     * @param string $url Абсолютный URL.
     * @return string Нормализованный URL.
     * @throws InvalidArgumentException Если URL невалиден или использует неподдерживаемую схему.
     */
    public function normalizeAbsoluteUrl(string $url): string
    {
        $parts = parse_url($url);
        if (!is_array($parts) || empty($parts['scheme']) || empty($parts['host'])) {
            throw new InvalidArgumentException('Некорректный URL.');
        }

        $scheme = strtolower((string)$parts['scheme']);
        if (!in_array($scheme, ['http', 'https'], true)) {
            throw new InvalidArgumentException('Разрешены только HTTP и HTTPS URL.');
        }

        $host = strtolower((string)$parts['host']);
        $path = $parts['path'] ?? '/';
        $path = $path === '' ? '/' : $path;
        $query = isset($parts['query']) && $parts['query'] !== '' ? '?' . $parts['query'] : '';

        return $scheme . '://' . $host . $path . $query;
    }

    /**
     * Превращает ссылку страницы в абсолютный URL.
     *
     * @param string $href Значение href.
     * @param string $baseUrl URL страницы-источника.
     * @return string|null Абсолютный URL или null для неподдерживаемой ссылки.
     * @throws InvalidArgumentException Если итоговый URL невалиден.
     */
    public function toAbsoluteUrl(string $href, string $baseUrl): ?string
    {
        $href = trim(html_entity_decode($href));
        if ($href === '' || str_starts_with($href, '#') || preg_match('~^(mailto|tel|javascript):~i', $href)) {
            return null;
        }

        if (preg_match('~^https?://~i', $href)) {
            return $this->normalizeAbsoluteUrl($href);
        }

        $base = parse_url($baseUrl);
        if (!is_array($base) || empty($base['scheme']) || empty($base['host'])) {
            return null;
        }

        if (str_starts_with($href, '//')) {
            return $this->normalizeAbsoluteUrl($base['scheme'] . ':' . $href);
        }

        if (str_starts_with($href, '/')) {
            return $this->normalizeAbsoluteUrl($base['scheme'] . '://' . $base['host'] . $href);
        }

        $basePath = $base['path'] ?? '/';
        $dir = rtrim((string)preg_replace('~/[^/]*$~', '/', $basePath), '/');

        return $this->normalizeAbsoluteUrl($base['scheme'] . '://' . $base['host'] . $dir . '/' . $href);
    }

    /**
     * Возвращает host из URL.
     *
     * @param string $url URL.
     * @return string Host URL.
     * @throws InvalidArgumentException Если host отсутствует.
     */
    public function host(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST);
        if (!is_string($host) || $host === '') {
            throw new InvalidArgumentException('URL не содержит host.');
        }

        return strtolower($host);
    }
}
