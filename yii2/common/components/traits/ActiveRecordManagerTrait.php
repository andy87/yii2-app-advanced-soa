<?php

namespace yii2\common\components\traits;

use yii\db\ActiveRecordInterface;

/**
 * Trait ClassManagerTrait
 *
 * @package yii2\common\components\traits
 */
trait ActiveRecordManagerTrait
{
    /** @var ActiveRecordInterface|string  */
    public ActiveRecordInterface|string $modelClass;



    /**
     * @param array $attributes
     *
     * @return ActiveRecordInterface
     */
    public function getModel( array $attributes = [] ): ActiveRecordInterface
    {
        $className = $this->getModelClass();

        return new $className( $attributes );
    }

    /**
     * @return ActiveRecordInterface|string
     */
    public function getModelClass(): ActiveRecordInterface|string
    {
        return $this->modelClass;
    }
}