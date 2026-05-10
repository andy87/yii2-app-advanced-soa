<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

/**
 * Контракт технической metadata LLM-клиента для безопасного логирования.
 *
 * @package yii2\common\services\audit\llm
 */
interface LlmClientMetadataInterface
{
    /**
     * Возвращает имя provider для логов.
     *
     * @return string Имя provider.
     */
    public function providerName(): string;

    /**
     * Возвращает имя модели для логов.
     *
     * @return string Имя модели.
     */
    public function modelName(): string;

    /**
     * Возвращает версию prompt для логов.
     *
     * @return string Версия prompt.
     */
    public function promptVersion(): string;
}
