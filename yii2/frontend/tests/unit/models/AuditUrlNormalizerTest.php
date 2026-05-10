<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use Codeception\Test\Unit;
use yii2\common\services\audit\crawler\HtmlParser;
use yii2\common\services\audit\crawler\UrlNormalizer;

/**
 * Unit-тесты нормализации URL и базового HTML-парсинга аудита.
 *
 * @package yii2\frontend\tests\unit\models
 */
final class AuditUrlNormalizerTest extends Unit
{
    /**
     * Проверяет добавление HTTPS и нормализацию пути.
     *
     * @return void
     */
    public function testNormalizeStartUrl(): void
    {
        $normalizer = new UrlNormalizer();

        verify($normalizer->normalizeStartUrl('Example.Ru'))->equals('https://example.ru/');
    }

    /**
     * Проверяет отклонение неподдерживаемой схемы.
     *
     * @return void
     */
    public function testRejectUnsupportedScheme(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new UrlNormalizer())->normalizeAbsoluteUrl('file:///etc/passwd');
    }

    /**
     * Проверяет извлечение title, description, H1, ссылок, форм и JSON-LD.
     *
     * @return void
     */
    public function testHtmlParser(): void
    {
        $html = '<html><head><title>Title</title><meta name="description" content="Description"><script type="application/ld+json">{"@type":"Organization"}</script></head><body><h1>Hello</h1><a href="/contacts">Contact</a><form method="post"><input name="email" required><button>Send</button></form></body></html>';
        $data = (new HtmlParser())->parse($html, 'https://example.ru/', new UrlNormalizer());

        verify($data['title'])->equals('Title');
        verify($data['description'])->equals('Description');
        verify($data['h1'])->equals(['Hello']);
        verify($data['links'][0]['url'])->equals('https://example.ru/contacts');
        verify($data['forms'][0]['hasSubmit'])->true();
        verify($data['schema'][0]['type'])->equals('json-ld');
    }
}
