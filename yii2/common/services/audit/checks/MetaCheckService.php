<?php declare(strict_types=1);

namespace yii2\common\services\audit\checks;

use yii2\common\models\audit\AuditPage;
use yii2\common\models\audit\Finding;

/**
 * Проверяет title, description, H1, canonical, schema, формы и CTA на уровне одной страницы.
 *
 * @package yii2\common\services\audit\checks
 */
final class MetaCheckService
{
    /**
     * Создаёт сервис проверки meta-признаков.
     *
     * @param FindingFactory $factory Фабрика findings.
     * @return void
     */
    public function __construct(private readonly FindingFactory $factory = new FindingFactory())
    {
    }

    /**
     * Выполняет проверки одной страницы.
     *
     * @param AuditPage $page Страница аудита.
     * @return void
     * @throws \RuntimeException Если finding не удалось сохранить.
     */
    public function check(AuditPage $page): void
    {
        $runId = (int)$page->audit_run_id;
        $h1 = $page->getJsonArray('h1_json');
        $forms = $page->getJsonArray('forms_json');
        $schema = $page->getJsonArray('schema_json');
        $links = $page->getJsonArray('links_json');

        if ($page->http_status === null || $page->http_status >= 400) {
            $this->factory->create($runId, $page, 'http_status', Finding::SEVERITY_CRITICAL, 'Страница недоступна или вернула ошибку', 'Crawler получил HTTP-статус, который может мешать пользователям и поисковым системам.', ['httpStatus' => $page->http_status], 'Проверить доступность URL, redirects и серверные ошибки.');
        }

        $titleLength = mb_strlen((string)$page->title);
        if ($page->title === null || trim($page->title) === '') {
            $this->factory->create($runId, $page, 'title_missing', Finding::SEVERITY_CRITICAL, 'Отсутствует title', 'У страницы не найден HTML title.', ['url' => $page->url], 'Добавить уникальный title, отражающий содержание страницы.');
        } elseif ($titleLength < 20 || $titleLength > 70) {
            $this->factory->create($runId, $page, 'title_length', Finding::SEVERITY_MEDIUM, 'Неоптимальная длина title', 'Title может быть слишком коротким или слишком длинным для понятного сниппета.', ['length' => $titleLength, 'title' => $page->title], 'Сделать title информативным, обычно в диапазоне 20-70 символов.');
        }

        $descriptionLength = mb_strlen((string)$page->description);
        if ($page->description === null || trim($page->description) === '') {
            $this->factory->create($runId, $page, 'description_missing', Finding::SEVERITY_MEDIUM, 'Отсутствует meta description', 'У страницы не найден meta description.', ['url' => $page->url], 'Добавить краткое описание страницы для поискового сниппета.');
        } elseif ($descriptionLength < 50 || $descriptionLength > 180) {
            $this->factory->create($runId, $page, 'description_length', Finding::SEVERITY_LOW, 'Неоптимальная длина meta description', 'Meta description может быть слишком коротким или длинным.', ['length' => $descriptionLength], 'Сделать описание конкретным и полезным для пользователя.');
        }

        if ($h1 === []) {
            $this->factory->create($runId, $page, 'h1_missing', Finding::SEVERITY_MEDIUM, 'Отсутствует H1', 'На странице не найден основной заголовок H1.', ['url' => $page->url], 'Добавить один понятный H1, соответствующий содержанию страницы.');
        } elseif (count($h1) > 1) {
            $this->factory->create($runId, $page, 'h1_multiple', Finding::SEVERITY_LOW, 'Несколько H1 на странице', 'На странице найдено больше одного H1.', ['h1' => $h1], 'Оставить один основной H1, остальные заголовки перевести на H2/H3.');
        }

        if ($page->canonical === null || trim($page->canonical) === '') {
            $this->factory->create($runId, $page, 'canonical_missing', Finding::SEVERITY_LOW, 'Отсутствует canonical', 'Canonical не найден. Для небольших сайтов это не всегда критично, но усложняет контроль дублей.', ['url' => $page->url], 'Добавить canonical, если есть риск дублей URL.');
        }

        if ($schema === []) {
            $this->factory->create($runId, $page, 'schema_missing', Finding::SEVERITY_LOW, 'Не найдены structured data', 'На странице не обнаружены JSON-LD или microdata.', ['url' => $page->url], 'Добавить базовую schema.org разметку Organization, LocalBusiness или подходящий тип.');
        }

        foreach ($forms as $index => $form) {
            if (empty($form['hasSubmit'])) {
                $this->factory->create($runId, $page, 'form_submit_missing', Finding::SEVERITY_MEDIUM, 'Форма без явной кнопки отправки', 'Crawler не нашёл submit-кнопку в форме.', ['formIndex' => $index, 'form' => $form], 'Проверить форму и добавить понятную кнопку отправки.');
            }
            if (($form['method'] ?? 'get') === 'get') {
                $this->factory->create($runId, $page, 'form_get_method', Finding::SEVERITY_LOW, 'Форма использует GET', 'Форма заявки может передавать данные в URL.', ['formIndex' => $index], 'Для контактных форм обычно использовать POST.');
            }
        }

        if (!$this->hasCta($links)) {
            $this->factory->create($runId, $page, 'cta_missing', Finding::SEVERITY_LOW, 'Не найден явный CTA', 'По простым текстовым эвристикам на странице не найден призыв к действию.', ['url' => $page->url], 'Проверить, есть ли заметная кнопка или ссылка для целевого действия.');
        }
    }

    /**
     * Проверяет наличие CTA по текстам ссылок.
     *
     * @param array $links Ссылки страницы.
     * @return bool Найден ли CTA.
     */
    private function hasCta(array $links): bool
    {
        $needles = ['заказать', 'оставить заявку', 'получить', 'записаться', 'купить', 'консультац', 'связаться', 'call', 'order', 'contact'];
        foreach ($links as $link) {
            $text = mb_strtolower((string)($link['text'] ?? ''));
            foreach ($needles as $needle) {
                if ($text !== '' && str_contains($text, $needle)) {
                    return true;
                }
            }
        }

        return false;
    }
}
