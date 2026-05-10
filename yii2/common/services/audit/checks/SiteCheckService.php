<?php declare(strict_types=1);

namespace yii2\common\services\audit\checks;

use yii2\common\models\audit\Finding;

/**
 * Выполняет проверки уровня сайта: robots.txt и sitemap.xml.
 *
 * @package yii2\common\services\audit\checks
 */
final class SiteCheckService
{
    /**
     * Создаёт сервис проверки сайта.
     *
     * @param FindingFactory $factory Фабрика findings.
     * @return void
     */
    public function __construct(private readonly FindingFactory $factory = new FindingFactory())
    {
    }

    /**
     * Проверяет служебные файлы сайта.
     *
     * @param int $auditRunId Идентификатор запуска аудита.
     * @param string $normalizedUrl Нормализованный URL домена.
     * @return void
     * @throws \RuntimeException Если finding не удалось сохранить.
     */
    public function check(int $auditRunId, string $normalizedUrl): void
    {
        $root = rtrim((string)parse_url($normalizedUrl, PHP_URL_SCHEME) . '://' . (string)parse_url($normalizedUrl, PHP_URL_HOST), '/');

        if (!$this->urlExists($root . '/robots.txt')) {
            $this->factory->create($auditRunId, null, 'robots_missing', Finding::SEVERITY_LOW, 'robots.txt не найден', 'Crawler не получил доступный robots.txt.', ['url' => $root . '/robots.txt'], 'Добавить robots.txt или проверить корректность ответа сервера.');
        }

        if (!$this->urlExists($root . '/sitemap.xml')) {
            $this->factory->create($auditRunId, null, 'sitemap_missing', Finding::SEVERITY_LOW, 'sitemap.xml не найден', 'Crawler не получил доступный sitemap.xml.', ['url' => $root . '/sitemap.xml'], 'Добавить sitemap.xml и указать его в robots.txt.');
        }
    }

    /**
     * Проверяет доступность URL через HEAD/GET без сохранения тела.
     *
     * @param string $url Проверяемый URL.
     * @return bool URL доступен со статусом меньше 400.
     */
    private function urlExists(string $url): bool
    {
        $ch = curl_init($url);
        if ($ch === false) {
            return false;
        }

        curl_setopt_array($ch, [
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => (int)($_ENV['AUDIT_REQUEST_TIMEOUT'] ?? 8),
            CURLOPT_USERAGENT => (string)($_ENV['AUDIT_USER_AGENT'] ?? 'SiteAuditorBot/0.1'),
        ]);

        curl_exec($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        return $status > 0 && $status < 400;
    }
}
