<?php declare(strict_types=1);

namespace yii2\common\services\audit\checks;

use yii2\common\models\audit\AuditPage;
use yii2\common\models\audit\Finding;

/**
 * Ищет дубли title, description и H1 среди просканированных страниц.
 *
 * @package yii2\common\services\audit\checks
 */
final class DuplicateCheckService
{
    /**
     * Создаёт сервис проверки дублей.
     *
     * @param FindingFactory $factory Фабрика findings.
     * @return void
     */
    public function __construct(private readonly FindingFactory $factory = new FindingFactory())
    {
    }

    /**
     * Выполняет проверку дублей.
     *
     * @param int $auditRunId Идентификатор запуска аудита.
     * @return void
     * @throws \RuntimeException Если finding не удалось сохранить.
     */
    public function check(int $auditRunId): void
    {
        $pages = AuditPage::find()->where(['audit_run_id' => $auditRunId])->all();
        $this->checkAttribute($auditRunId, $pages, 'title', 'duplicate_title', 'Дублирующийся title');
        $this->checkAttribute($auditRunId, $pages, 'description', 'duplicate_description', 'Дублирующийся meta description');
        $this->checkH1($auditRunId, $pages);
    }

    /**
     * Проверяет дубли простого атрибута.
     *
     * @param int $auditRunId Идентификатор запуска аудита.
     * @param AuditPage[] $pages Страницы аудита.
     * @param string $attribute Атрибут страницы.
     * @param string $type Тип finding.
     * @param string $title Заголовок finding.
     * @return void
     * @throws \RuntimeException Если finding не удалось сохранить.
     */
    private function checkAttribute(int $auditRunId, array $pages, string $attribute, string $type, string $title): void
    {
        $map = [];
        foreach ($pages as $page) {
            $value = trim((string)$page->{$attribute});
            if ($value !== '') {
                $map[mb_strtolower($value)][] = $page->url;
            }
        }

        foreach ($map as $value => $urls) {
            if (count($urls) > 1) {
                $this->factory->create($auditRunId, null, $type, Finding::SEVERITY_MEDIUM, $title, 'Несколько страниц имеют одинаковое значение важного SEO-атрибута.', ['value' => $value, 'urls' => $urls], 'Сделать значения уникальными с учётом назначения каждой страницы.');
            }
        }
    }

    /**
     * Проверяет дубли первого H1.
     *
     * @param int $auditRunId Идентификатор запуска аудита.
     * @param AuditPage[] $pages Страницы аудита.
     * @return void
     * @throws \RuntimeException Если finding не удалось сохранить.
     */
    private function checkH1(int $auditRunId, array $pages): void
    {
        $map = [];
        foreach ($pages as $page) {
            $h1 = $page->getJsonArray('h1_json');
            $value = trim((string)($h1[0] ?? ''));
            if ($value !== '') {
                $map[mb_strtolower($value)][] = $page->url;
            }
        }

        foreach ($map as $value => $urls) {
            if (count($urls) > 1) {
                $this->factory->create($auditRunId, null, 'duplicate_h1', Finding::SEVERITY_MEDIUM, 'Дублирующийся H1', 'Несколько страниц имеют одинаковый основной заголовок.', ['value' => $value, 'urls' => $urls], 'Сделать H1 уникальными и связанными с содержанием страниц.');
            }
        }
    }
}
