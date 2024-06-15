<?php

namespace app\common\components\services;

use app\common\components\core\BaseModel;

/**
 * < Common > `FormService`
 *
 * @package app\common\components\services
 */
abstract class FormService extends ModelService
{
    /** @var string  */
    public const CLASS_FORM = BaseModel::class;



    /**
     * @return BaseModel|string
     *
     * @tag #core #service #get
     */
    public function getClassForm(): BaseModel|string
    {
        /** @var static|string $classForm */
        $classForm = static::CLASS_FORM;

        return $classForm;
    }

    /**
     * @param array $attributes
     *
     * @return BaseModel|string
     *
     * @tag #core #service #create
     */
    public function createForm(array $attributes = []): BaseModel|string
    {
        $classForm = $this->getClassModel();

        return new $classForm($attributes);
    }
}