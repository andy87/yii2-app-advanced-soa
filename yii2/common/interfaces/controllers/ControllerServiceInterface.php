<?php declare(strict_types=1);

namespace common\interfaces\controllers;

use common\components\base\services\items\BaseService;

/**
 * < Common >
 *
 * @property BaseService $service
 *
 * @package yii2\common\components\interfaces\controllers\items
 *
 * @tag: #abstract #common #interface #controller #service
 */
interface ControllerServiceInterface
{
    public function setupService(): bool;
}