<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\dto\LlmReportResponseDto;

/**
 * Контракт LLM-провайдера для генерации черновика отчёта.
 *
 * @package yii2\common\services\audit\llm
 */
interface LlmClientInterface
{
    /**
     * Генерирует структурированный черновик отчёта из normalized findings.
     *
     * @param LlmReportRequestDto $request Нормализованный запрос без лишних персональных данных.
     * @return LlmReportResponseDto Черновик отчёта и token metadata.
     * @throws LlmClientException При ошибке провайдера или невалидном ответе.
     */
    public function generateAuditReport(LlmReportRequestDto $request): LlmReportResponseDto;
}
