<?php

namespace yii2\common\components\interfaces\handlers;

use yii2\common\components\viewModels\TemplateViewModel;

/**
 * Interface HandlerInterface
 *
 * @package yii2\common\components\interfaces\handlers
 */
interface TemplateHandlerInterface
{
    public function getResource(string $action): ?TemplateViewModel;
}