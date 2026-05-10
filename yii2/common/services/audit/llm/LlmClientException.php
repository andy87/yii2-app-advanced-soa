<?php declare(strict_types=1);

namespace yii2\common\services\audit\llm;

use RuntimeException;

/**
 * Исключение LLM-клиента при ошибке провайдера или невалидном ответе.
 *
 * @package yii2\common\services\audit\llm
 */
class LlmClientException extends RuntimeException
{
}
