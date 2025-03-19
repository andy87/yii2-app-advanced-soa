<?php declare(strict_types=1);

namespace yii2\common\components\services;

use yii2\common\components\core\BaseModel;
use yii2\common\components\interfaces\services\FormServiceInterface;

/**
 * < Common > `FormService`
 *
 * @package yii2\common\components\services
 */
abstract class FormService extends ActiveRecordService implements FormServiceInterface
{
    /** @var BaseModel|string Класс формы */
    protected BaseModel|string $formClass;



    /**
     * @return BaseModel|string
     *
     * @tag #core #service #get
     */
    public function getClassForm(): BaseModel|string
    {
        /** @var static|string $classForm */
        $classForm = $this->formClass;

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