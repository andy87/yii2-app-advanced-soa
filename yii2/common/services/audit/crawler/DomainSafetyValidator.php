<?php declare(strict_types=1);

namespace yii2\common\services\audit\crawler;

use InvalidArgumentException;

/**
 * Проверяет URL и DNS-адреса на базовые SSRF-риски.
 *
 * @package yii2\common\services\audit\crawler
 */
final class DomainSafetyValidator
{
    /**
     * Проверяет URL перед сетевым запросом crawler.
     *
     * @param string $url Абсолютный URL.
     * @return void
     * @throws InvalidArgumentException Если URL ведёт во внутреннюю сеть или использует опасный host.
     */
    public function assertSafeUrl(string $url): void
    {
        $parts = parse_url($url);
        if (!is_array($parts) || empty($parts['scheme']) || empty($parts['host'])) {
            throw new InvalidArgumentException('Некорректный URL для проверки безопасности.');
        }

        $scheme = strtolower((string)$parts['scheme']);
        if (!in_array($scheme, ['http', 'https'], true)) {
            throw new InvalidArgumentException('Crawler поддерживает только HTTP и HTTPS.');
        }

        $host = strtolower((string)$parts['host']);
        if ($host === 'localhost' || str_ends_with($host, '.local')) {
            throw new InvalidArgumentException('Локальные host запрещены для аудита.');
        }

        $records = dns_get_record($host, DNS_A + DNS_AAAA);
        if ($records === [] || $records === false) {
            throw new InvalidArgumentException('Не удалось разрешить DNS host.');
        }

        foreach ($records as $record) {
            $ip = $record['ip'] ?? $record['ipv6'] ?? null;
            if (is_string($ip) && !$this->isPublicIp($ip)) {
                throw new InvalidArgumentException('URL разрешается во внутренний или служебный IP.');
            }
        }
    }

    /**
     * Проверяет, является ли IP публичным.
     *
     * @param string $ip IPv4 или IPv6.
     * @return bool Публичный IP.
     */
    private function isPublicIp(string $ip): bool
    {
        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;
    }
}
