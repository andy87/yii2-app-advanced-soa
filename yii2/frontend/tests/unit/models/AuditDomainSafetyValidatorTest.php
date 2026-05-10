<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use Codeception\Test\Unit;
use InvalidArgumentException;
use yii2\common\services\audit\crawler\DomainSafetyValidator;

/**
 * Unit-тесты SSRF-защиты и DNS pinning для crawler HTTP-запросов.
 *
 * @package yii2\frontend\tests\unit\models
 */
final class AuditDomainSafetyValidatorTest extends Unit
{
    /**
     * Проверяет создание CURLOPT_RESOLVE для проверенного публичного DNS.
     *
     * @return void
     */
    public function testCurlOptionsPinResolvedPublicIp(): void
    {
        $validator = new DomainSafetyValidator(static fn(string $host): array => [
            ['host' => $host, 'ip' => '93.184.216.34'],
        ]);

        $options = $validator->curlOptionsForUrl('https://example.com/path');

        verify($options[CURLOPT_RESOLVE])->equals(['example.com:443:93.184.216.34']);
    }

    /**
     * Проверяет запрет DNS-записи во внутреннюю сеть.
     *
     * @return void
     */
    public function testRejectsPrivateDnsRecord(): void
    {
        $validator = new DomainSafetyValidator(static fn(string $host): array => [
            ['host' => $host, 'ip' => '127.0.0.1'],
        ]);

        $this->expectException(InvalidArgumentException::class);

        $validator->curlOptionsForUrl('https://example.com/');
    }

    /**
     * Проверяет запрет DNS-ответа со смешанными public/private адресами.
     *
     * @return void
     */
    public function testRejectsMixedPublicAndPrivateDnsRecords(): void
    {
        $validator = new DomainSafetyValidator(static fn(string $host): array => [
            ['host' => $host, 'ip' => '93.184.216.34'],
            ['host' => $host, 'ip' => '10.0.0.5'],
        ]);

        $this->expectException(InvalidArgumentException::class);

        $validator->curlOptionsForUrl('https://example.com/');
    }

    /**
     * Проверяет запрет IP-literal во внутреннюю сеть.
     *
     * @return void
     */
    public function testRejectsPrivateIpLiteral(): void
    {
        $validator = new DomainSafetyValidator();

        $this->expectException(InvalidArgumentException::class);

        $validator->assertSafeUrl('http://10.0.0.1/');
    }

    /**
     * Проверяет запрет localhost с завершающей точкой.
     *
     * @return void
     */
    public function testRejectsLocalhostWithTrailingDot(): void
    {
        $validator = new DomainSafetyValidator();

        $this->expectException(InvalidArgumentException::class);

        $validator->assertSafeUrl('http://localhost./');
    }

    /**
     * Проверяет запрет private IPv6 literal.
     *
     * @return void
     */
    public function testRejectsPrivateIpv6Literal(): void
    {
        $validator = new DomainSafetyValidator();

        $this->expectException(InvalidArgumentException::class);

        $validator->assertSafeUrl('http://[::1]/');
    }
}
