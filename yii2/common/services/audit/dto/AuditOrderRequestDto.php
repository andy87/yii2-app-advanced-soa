<?php declare(strict_types=1);

namespace yii2\common\services\audit\dto;

/**
 * DTO запроса на создание заказа аудита.
 *
 * @package yii2\common\services\audit\dto
 */
final class AuditOrderRequestDto
{
    /**
     * Создаёт DTO заказа аудита.
     *
     * @param int $userId Идентификатор пользователя.
     * @param string $domainUrl Введённый URL или домен.
     * @param string $tariff Тариф аудита.
     * @param int $pageLimit Лимит страниц.
     * @param string|null $notes Примечание к заказу.
     * @return void
     */
    public function __construct(
        public readonly int $userId,
        public readonly string $domainUrl,
        public readonly string $tariff,
        public readonly int $pageLimit,
        public readonly ?string $notes = null,
    ) {
    }
}
