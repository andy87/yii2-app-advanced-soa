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
     * Создаёт валидатор сетевой безопасности.
     *
     * @param \Closure|null $dnsResolver Callback DNS-резолвинга для тестов.
     * @return void
     */
    public function __construct(private readonly ?\Closure $dnsResolver = null)
    {
    }

    /**
     * Проверяет URL перед сетевым запросом crawler.
     *
     * @param string $url Абсолютный URL.
     * @return void
     * @throws InvalidArgumentException Если URL ведёт во внутреннюю сеть или использует опасный host.
     */
    public function assertSafeUrl(string $url): void
    {
        $this->resolvePublicIps($url);
    }

    /**
     * Возвращает cURL options, pin-ящие host к уже проверенным публичным IP.
     *
     * @param string $url Абсолютный URL.
     * @return array<int, mixed> Options для curl_setopt_array().
     * @throws InvalidArgumentException Если URL небезопасен.
     */
    public function curlOptionsForUrl(string $url): array
    {
        $parts = $this->safeUrlParts($url);
        $curlHost = strtolower((string)$parts['host']);
        if ($this->isIpLiteral($curlHost)) {
            return [];
        }

        $port = (int)($parts['port'] ?? ($parts['scheme'] === 'https' ? 443 : 80));
        $resolve = [];
        foreach ($this->resolvePublicIps($url) as $ip) {
            $resolve[] = $curlHost . ':' . $port . ':' . $this->curlResolveIp($ip);
        }

        return $resolve === [] ? [] : [CURLOPT_RESOLVE => $resolve];
    }

    /**
     * Разбирает и проверяет базовую структуру URL.
     *
     * @param string $url Абсолютный URL.
     * @return array Разобранный URL.
     * @throws InvalidArgumentException Если URL невалиден или использует опасный host.
     */
    private function safeUrlParts(string $url): array
    {
        $parts = parse_url($url);
        if (!is_array($parts) || empty($parts['scheme']) || empty($parts['host'])) {
            throw new InvalidArgumentException('Некорректный URL для проверки безопасности.');
        }

        $scheme = strtolower((string)$parts['scheme']);
        if (!in_array($scheme, ['http', 'https'], true)) {
            throw new InvalidArgumentException('Crawler поддерживает только HTTP и HTTPS.');
        }

        $host = $this->hostForValidation((string)$parts['host']);
        if ($host === '') {
            throw new InvalidArgumentException('Некорректный host для проверки безопасности.');
        }
        if ($host === 'localhost' || str_ends_with($host, '.local')) {
            throw new InvalidArgumentException('Локальные host запрещены для аудита.');
        }

        return $parts;
    }

    /**
     * Резолвит host и возвращает проверенные публичные IP.
     *
     * @param string $url Абсолютный URL.
     * @return string[] Публичные IP.
     * @throws InvalidArgumentException Если DNS ведёт во внутреннюю сеть.
     */
    private function resolvePublicIps(string $url): array
    {
        $parts = $this->safeUrlParts($url);
        $host = $this->hostForValidation((string)$parts['host']);

        if (filter_var($host, FILTER_VALIDATE_IP) !== false) {
            if (!$this->isPublicIp($host)) {
                throw new InvalidArgumentException('URL использует внутренний или служебный IP.');
            }

            return [$host];
        }

        $records = $this->resolveDns($host);
        if ($records === [] || $records === false) {
            throw new InvalidArgumentException('Не удалось разрешить DNS host.');
        }

        $ips = [];
        foreach ($records as $record) {
            $ip = $record['ip'] ?? $record['ipv6'] ?? null;
            if (is_string($ip) && !$this->isPublicIp($ip)) {
                throw new InvalidArgumentException('URL разрешается во внутренний или служебный IP.');
            }
            if (is_string($ip)) {
                $ips[] = $ip;
            }
        }

        $ips = array_values(array_unique($ips));
        if ($ips === []) {
            throw new InvalidArgumentException('DNS host не содержит A/AAAA записей.');
        }

        return $ips;
    }

    /**
     * Выполняет DNS-резолвинг host.
     *
     * @param string $host Имя host.
     * @return array|false DNS-записи.
     */
    private function resolveDns(string $host): array|false
    {
        if ($this->dnsResolver !== null) {
            return ($this->dnsResolver)($host);
        }

        return dns_get_record($host, DNS_A + DNS_AAAA);
    }

    /**
     * Нормализует host для проверок безопасности.
     *
     * @param string $host Host из URL.
     * @return string Host без IPv6-скобок и завершающей точки.
     */
    private function hostForValidation(string $host): string
    {
        $host = strtolower($host);
        if (str_starts_with($host, '[') && str_ends_with($host, ']')) {
            $host = substr($host, 1, -1);
        }

        return rtrim($host, '.');
    }

    /**
     * Проверяет, является ли host IP-literal.
     *
     * @param string $host Host из URL.
     * @return bool Host является IPv4/IPv6 literal.
     */
    private function isIpLiteral(string $host): bool
    {
        return filter_var($this->hostForValidation($host), FILTER_VALIDATE_IP) !== false;
    }

    /**
     * Форматирует IP для CURLOPT_RESOLVE.
     *
     * @param string $ip IPv4 или IPv6.
     * @return string Значение IP для cURL resolve entry.
     */
    private function curlResolveIp(string $ip): string
    {
        return str_contains($ip, ':') ? '[' . $ip . ']' : $ip;
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
