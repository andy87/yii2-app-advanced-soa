<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

use yii2\common\models\audit\AuditRun;
use yii2\common\models\audit\LlmCallLog;
use yii2\common\models\audit\Report;
use yii2\common\services\audit\dto\LlmReportRequestDto;
use yii2\common\services\audit\dto\LlmReportResponseDto;

/**
 * Сервис безопасного логирования LLM-вызовов без сырого prompt и API response.
 *
 * @package yii2\common\services\audit\llm
 */
final class LlmCallLogService
{
    /**
     * Сохраняет successful LLM-вызов.
     *
     * @param AuditRun $run Запуск аудита.
     * @param Report $report Отчёт.
     * @param LlmClientInterface $client LLM-клиент.
     * @param LlmReportRequestDto $request Нормализованный request.
     * @param LlmReportResponseDto $response Нормализованный response DTO.
     * @return LlmCallLog Сохранённый лог.
     * @throws \RuntimeException Если лог не удалось сохранить.
     */
    public function logSuccess(
        AuditRun $run,
        Report $report,
        LlmClientInterface $client,
        LlmReportRequestDto $request,
        LlmReportResponseDto $response,
    ): LlmCallLog {
        $attributes = $this->successAttributes($run, $report, $client, $request, $response);

        return $this->save($attributes);
    }

    /**
     * Сохраняет failed LLM-вызов.
     *
     * @param AuditRun $run Запуск аудита.
     * @param LlmClientInterface $client LLM-клиент.
     * @param LlmReportRequestDto $request Нормализованный request.
     * @param \Throwable $exception Ошибка provider/validation.
     * @return LlmCallLog Сохранённый лог.
     * @throws \RuntimeException Если лог не удалось сохранить.
     */
    public function logFailure(
        AuditRun $run,
        LlmClientInterface $client,
        LlmReportRequestDto $request,
        \Throwable $exception,
    ): LlmCallLog {
        $attributes = $this->failureAttributes($run, $client, $request, $exception);

        return $this->save($attributes);
    }

    /**
     * Формирует атрибуты successful лога.
     *
     * @param AuditRun $run Запуск аудита.
     * @param Report $report Отчёт.
     * @param LlmClientInterface $client LLM-клиент.
     * @param LlmReportRequestDto $request Нормализованный request.
     * @param LlmReportResponseDto $response Нормализованный response DTO.
     * @return array Атрибуты `llm_call_logs`.
     */
    public function successAttributes(
        AuditRun $run,
        Report $report,
        LlmClientInterface $client,
        LlmReportRequestDto $request,
        LlmReportResponseDto $response,
    ): array {
        return [
            'audit_run_id' => $run->id,
            'report_id' => $report->id,
            'provider' => $this->providerName($client),
            'model' => $response->model,
            'prompt_version' => $response->promptVersion,
            'request_hash' => $this->requestHash($request),
            'response_hash' => $this->responseHash($response),
            'http_status' => null,
            'input_tokens' => $response->inputTokens,
            'output_tokens' => $response->outputTokens,
            'status' => LlmCallLog::STATUS_SUCCESS,
            'error_message' => null,
        ];
    }

    /**
     * Формирует атрибуты failed лога.
     *
     * @param AuditRun $run Запуск аудита.
     * @param LlmClientInterface $client LLM-клиент.
     * @param LlmReportRequestDto $request Нормализованный request.
     * @param \Throwable $exception Ошибка provider/validation.
     * @return array Атрибуты `llm_call_logs`.
     */
    public function failureAttributes(
        AuditRun $run,
        LlmClientInterface $client,
        LlmReportRequestDto $request,
        \Throwable $exception,
    ): array {
        return $this->failureAttributesByRunId((int)$run->id, $client, $request, $exception);
    }

    /**
     * Формирует атрибуты failed лога по идентификатору запуска.
     *
     * @param int $auditRunId Идентификатор запуска аудита.
     * @param LlmClientInterface $client LLM-клиент.
     * @param LlmReportRequestDto $request Нормализованный request.
     * @param \Throwable $exception Ошибка provider/validation.
     * @return array Атрибуты `llm_call_logs`.
     */
    public function failureAttributesByRunId(
        int $auditRunId,
        LlmClientInterface $client,
        LlmReportRequestDto $request,
        \Throwable $exception,
    ): array {
        return [
            'audit_run_id' => $auditRunId,
            'report_id' => null,
            'provider' => $this->providerName($client),
            'model' => $this->modelName($client),
            'prompt_version' => $this->promptVersion($client),
            'request_hash' => $this->requestHash($request),
            'response_hash' => null,
            'http_status' => $this->httpStatus($exception),
            'input_tokens' => null,
            'output_tokens' => null,
            'status' => LlmCallLog::STATUS_FAILED,
            'error_message' => $this->safeErrorMessage($exception),
        ];
    }

    /**
     * Сохраняет LLM log.
     *
     * @param array $attributes Атрибуты модели.
     * @return LlmCallLog Сохранённая модель.
     * @throws \RuntimeException Если модель не прошла сохранение.
     */
    private function save(array $attributes): LlmCallLog
    {
        $log = new LlmCallLog($attributes);

        if (!$log->save()) {
            throw new \RuntimeException('Не удалось сохранить LLM log: ' . json_encode($log->errors, JSON_UNESCAPED_UNICODE));
        }

        return $log;
    }

    /**
     * Возвращает безопасный hash нормализованного request.
     *
     * @param LlmReportRequestDto $request Нормализованный request.
     * @return string SHA-256 hash.
     */
    private function requestHash(LlmReportRequestDto $request): string
    {
        return hash('sha256', json_encode([
            'domain' => $request->domain,
            'pagesScanned' => $request->pagesScanned,
            'findings' => $request->findings,
            'limitations' => $request->limitations,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Возвращает безопасный hash нормализованного response DTO.
     *
     * @param LlmReportResponseDto $response Нормализованный response DTO.
     * @return string SHA-256 hash.
     */
    private function responseHash(LlmReportResponseDto $response): string
    {
        return hash('sha256', json_encode([
            'summary' => $response->summary,
            'tasks' => $response->tasks,
            'model' => $response->model,
            'promptVersion' => $response->promptVersion,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Возвращает HTTP status из exception code.
     *
     * @param \Throwable $exception Ошибка provider/validation.
     * @return int|null HTTP status или null для не-HTTP ошибки.
     */
    private function httpStatus(\Throwable $exception): ?int
    {
        $code = (int)$exception->getCode();

        return $code >= 100 && $code <= 599 ? $code : null;
    }

    /**
     * Возвращает безопасное сообщение об ошибке без сырого API response для HTTP-ошибок.
     *
     * @param \Throwable $exception Ошибка provider/validation.
     * @return string Безопасное сообщение для хранения.
     */
    private function safeErrorMessage(\Throwable $exception): string
    {
        $httpStatus = $this->httpStatus($exception);
        if ($httpStatus !== null) {
            return "LLM provider HTTP {$httpStatus}.";
        }

        return mb_substr($exception->getMessage(), 0, 2000);
    }

    /**
     * Возвращает имя provider.
     *
     * @param LlmClientInterface $client LLM-клиент.
     * @return string Имя provider.
     */
    private function providerName(LlmClientInterface $client): string
    {
        if ($client instanceof LlmClientMetadataInterface) {
            return $client->providerName();
        }

        return (new \ReflectionClass($client))->getShortName();
    }

    /**
     * Возвращает имя модели.
     *
     * @param LlmClientInterface $client LLM-клиент.
     * @return string Имя модели.
     */
    private function modelName(LlmClientInterface $client): string
    {
        return $client instanceof LlmClientMetadataInterface ? $client->modelName() : 'unknown';
    }

    /**
     * Возвращает версию prompt.
     *
     * @param LlmClientInterface $client LLM-клиент.
     * @return string Версия prompt.
     */
    private function promptVersion(LlmClientInterface $client): string
    {
        return $client instanceof LlmClientMetadataInterface ? $client->promptVersion() : 'unknown';
    }
}
