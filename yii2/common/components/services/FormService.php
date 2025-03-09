<?php declare(strict_types=1);

namespace yii2\common\components\services;

use yii2\common\components\core\BaseModel;

/**
 * < Common > `FormService`
 *
 * @package yii2\common\components\services
 */
abstract class FormService extends ActiveRecordService
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
        $classForm = $this->getClassForm();

        return new $classForm($attributes);
    }
}