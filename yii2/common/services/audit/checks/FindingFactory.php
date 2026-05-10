<?php declare(strict_types=1);

namespace yii2\common\services\audit\checks;

use yii2\common\models\audit\AuditPage;
use yii2\common\models\audit\Finding;

/**
 * Фабрика сохранения deterministic findings.
 *
 * @package yii2\common\services\audit\checks
 */
final class FindingFactory
{
    /**
     * Создаёт и сохраняет finding.
     *
     * @param int $auditRunId Идентификатор запуска аудита.
     * @param AuditPage|null $page Страница finding или null для finding уровня сайта.
     * @param string $type Тип finding.
     * @param string $severity Важность finding.
     * @param string $title Заголовок finding.
     * @param string $description Описание finding.
     * @param array $evidence Доказательства.
     * @param string|null $recommendation Рекомендация.
     * @return Finding Сохранённый finding.
     * @throws \RuntimeException Если finding не удалось сохранить.
     */
    public function create(
        int $auditRunId,
        ?AuditPage $page,
        string $type,
        string $severity,
        string $title,
        string $description,
        array $evidence = [],
        ?string $recommendation = null,
    ): Finding {
        $finding = new Finding([
            'audit_run_id' => $auditRunId,
            'page_id' => $page?->id,
            'type' => $type,
            'severity' => $severity,
            'title' => $title,
            'description' => $description,
            'evidence_json' => $evidence,
            'recommendation' => $recommendation,
        ]);

        if (!$finding->save()) {
            throw new \RuntimeException('Не удалось сохранить finding: ' . json_encode($finding->errors, JSON_UNESCAPED_UNICODE));
        }

        return $finding;
    }
}
