<?php

namespace yii2\common\components\traits;

use yii\base\Model;
use yii\db\ActiveRecordInterface;

/**
 * Trait ClassManagerTrait
 *
 * @package yii2\common\components\traits
 */
trait ModelManagerTrait
{
    /** @var ActiveRecordInterface|string  */
    public ActiveRecordInterface|string $formClass;



    /**
     * @param array $attributes
     *
     * @return ActiveRecordInterface
     */
    public function getModelForm( array $attributes = [] ): Model
    {
        $className = $this->getFormClass();

        return new $className( $attributes );
    }

    /**
     * @return ActiveRecordInterface|string
     */
    public function getFormClass(): Model|string
    {
        return $this->formClass;
    }
}