<?php declare(strict_types=1);

namespace yii2\common\services\audit\crawler;

use DOMDocument;
use DOMElement;
use DOMXPath;

/**
 * Извлекает нормализованные данные из HTML без выполнения JavaScript.
 *
 * @package yii2\common\services\audit\crawler
 */
final class HtmlParser
{
    /**
     * Разбирает HTML страницы.
     *
     * @param string $html HTML документа.
     * @param string $baseUrl URL страницы.
     * @param UrlNormalizer $normalizer Нормализатор URL.
     * @return array Нормализованные title, description, canonical, h1, links, forms, schema.
     */
    public function parse(string $html, string $baseUrl, UrlNormalizer $normalizer): array
    {
        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR | LIBXML_NONET);
        libxml_clear_errors();

        $xpath = new DOMXPath($document);

        return [
            'title' => $this->text($xpath, '//title'),
            'description' => $this->metaContent($xpath, 'description'),
            'canonical' => $this->linkHref($xpath, 'canonical'),
            'h1' => $this->texts($xpath, '//h1'),
            'links' => $this->links($xpath, $baseUrl, $normalizer),
            'forms' => $this->forms($xpath),
            'schema' => $this->schema($xpath),
        ];
    }

    /**
     * Возвращает первый текст по XPath.
     *
     * @param DOMXPath $xpath XPath-доступ к документу.
     * @param string $query XPath-запрос.
     * @return string|null Найденный текст.
     */
    private function text(DOMXPath $xpath, string $query): ?string
    {
        $nodes = $xpath->query($query);
        if ($nodes === false || $nodes->length === 0) {
            return null;
        }

        return trim((string)$nodes->item(0)?->textContent) ?: null;
    }

    /**
     * Возвращает все непустые тексты по XPath.
     *
     * @param DOMXPath $xpath XPath-доступ к документу.
     * @param string $query XPath-запрос.
     * @return string[] Найденные тексты.
     */
    private function texts(DOMXPath $xpath, string $query): array
    {
        $result = [];
        $nodes = $xpath->query($query);
        if ($nodes === false) {
            return $result;
        }

        foreach ($nodes as $node) {
            $text = trim((string)$node->textContent);
            if ($text !== '') {
                $result[] = $text;
            }
        }

        return $result;
    }

    /**
     * Возвращает content meta-тега по имени.
     *
     * @param DOMXPath $xpath XPath-доступ к документу.
     * @param string $name Имя meta-тега.
     * @return string|null Значение content.
     */
    private function metaContent(DOMXPath $xpath, string $name): ?string
    {
        $nodes = $xpath->query('//meta[translate(@name, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")="' . strtolower($name) . '"]');
        if ($nodes === false || $nodes->length === 0) {
            return null;
        }

        $node = $nodes->item(0);
        if (!$node instanceof DOMElement) {
            return null;
        }

        return trim($node->getAttribute('content')) ?: null;
    }

    /**
     * Возвращает href link-тега по rel.
     *
     * @param DOMXPath $xpath XPath-доступ к документу.
     * @param string $rel Значение rel.
     * @return string|null Значение href.
     */
    private function linkHref(DOMXPath $xpath, string $rel): ?string
    {
        $nodes = $xpath->query('//link[translate(@rel, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")="' . strtolower($rel) . '"]');
        if ($nodes === false || $nodes->length === 0) {
            return null;
        }

        $node = $nodes->item(0);
        if (!$node instanceof DOMElement) {
            return null;
        }

        return trim($node->getAttribute('href')) ?: null;
    }

    /**
     * Извлекает ссылки страницы.
     *
     * @param DOMXPath $xpath XPath-доступ к документу.
     * @param string $baseUrl URL страницы.
     * @param UrlNormalizer $normalizer Нормализатор URL.
     * @return array Ссылки страницы.
     */
    private function links(DOMXPath $xpath, string $baseUrl, UrlNormalizer $normalizer): array
    {
        $links = [];
        $nodes = $xpath->query('//a[@href]');
        if ($nodes === false) {
            return $links;
        }

        foreach ($nodes as $node) {
            if (!$node instanceof DOMElement) {
                continue;
            }

            try {
                $absolute = $normalizer->toAbsoluteUrl($node->getAttribute('href'), $baseUrl);
            } catch (\Throwable) {
                $absolute = null;
            }

            if ($absolute !== null) {
                $links[] = [
                    'url' => $absolute,
                    'text' => trim((string)$node->textContent),
                ];
            }
        }

        return $links;
    }

    /**
     * Извлекает формы страницы без отправки данных.
     *
     * @param DOMXPath $xpath XPath-доступ к документу.
     * @return array Формы страницы.
     */
    private function forms(DOMXPath $xpath): array
    {
        $forms = [];
        $nodes = $xpath->query('//form');
        if ($nodes === false) {
            return $forms;
        }

        foreach ($nodes as $form) {
            if (!$form instanceof DOMElement) {
                continue;
            }

            $inputs = [];
            foreach ($form->getElementsByTagName('input') as $input) {
                $inputs[] = [
                    'name' => $input->getAttribute('name'),
                    'type' => $input->getAttribute('type') ?: 'text',
                    'required' => $input->hasAttribute('required'),
                    'id' => $input->getAttribute('id'),
                ];
            }

            $forms[] = [
                'action' => $form->getAttribute('action'),
                'method' => strtolower($form->getAttribute('method') ?: 'get'),
                'hasSubmit' => $form->getElementsByTagName('button')->length > 0 || $this->hasSubmitInput($form),
                'inputs' => $inputs,
            ];
        }

        return $forms;
    }

    /**
     * Проверяет наличие submit input в форме.
     *
     * @param DOMElement $form HTML-форма.
     * @return bool Есть ли submit input.
     */
    private function hasSubmitInput(DOMElement $form): bool
    {
        foreach ($form->getElementsByTagName('input') as $input) {
            if (strtolower($input->getAttribute('type')) === 'submit') {
                return true;
            }
        }

        return false;
    }

    /**
     * Извлекает structured data на базовом уровне.
     *
     * @param DOMXPath $xpath XPath-доступ к документу.
     * @return array Найденные structured data признаки.
     */
    private function schema(DOMXPath $xpath): array
    {
        $schema = [];
        $jsonLd = $xpath->query('//script[@type="application/ld+json"]');
        if ($jsonLd !== false) {
            foreach ($jsonLd as $node) {
                $schema[] = ['type' => 'json-ld', 'snippet' => mb_substr(trim((string)$node->textContent), 0, 500)];
            }
        }

        $items = $xpath->query('//*[@itemscope]');
        if ($items !== false && $items->length > 0) {
            $schema[] = ['type' => 'microdata', 'count' => $items->length];
        }

        return $schema;
    }
}
