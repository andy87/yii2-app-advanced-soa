<?php

namespace yii2\common\components\interfaces\services;

use yii2\common\components\core\BaseModel;

/**
 * Interface FormService
 *
 * @package yii2\common\components\interfaces\services
 */
interface FormServiceInterface
{
    /**
     * @return BaseModel|string
     */
    public function getClassForm(): BaseModel|string;

    /**
     * @param array $attributes
     *
     * @return BaseModel|string
     */
    public function createForm(array $attributes = []): BaseModel|string;
}