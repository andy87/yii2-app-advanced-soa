<?php

namespace yii2\common\components\core;

use yii\base\Model;
use yii\base\BaseObject;
use yii\db\ActiveRecordInterface;
use yii2\common\components\traits\ActiveRecordManagerTrait;

/**
 * < Common > `BaseProduces`
 *
 *  create( attributes )
 *      attributes = prepareCreateParams( attributes ) // optional override for data manipulation
 *      model = afterCreateModel( model ) // optional override for model manipulation
 *      return model
 *
 *  add( data )
 *      data = prepareAddParams( data ) // optional override for data manipulation
 *      model = beforeSave( model ) // optional override for model manipulation
 *      model = afterSave( model ) // optional override for model manipulation
 *      return model
 *
 * @package yii2\common\components\core
 */
abstract class BaseProduces extends BaseObject
{
    use ActiveRecordManagerTrait;


    /**
     * @param array $attributes
     * @param string $scenario
     *
     * @return ActiveRecordInterface
     */
    public function create( array $attributes = [], string $scenario = Model::SCENARIO_DEFAULT ): ActiveRecordInterface
    {
        $attributes = $this->prepareCreateParams($attributes);

        $model = $this->getModel($attributes);

        if ($scenario) $model->setScenario($scenario);

        $this->afterCreateModel($model);

        return $model;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function prepareCreateParams( array $data ): array
    {
        return $data;
    }

    /**
     * @param ActiveRecordInterface $model
     *
     * @return void
     */
    public function afterCreateModel( ActiveRecordInterface $model ): void
    {
        // boilerplate
    }

    /**
     * @param array $data
     *
     * @return ActiveRecordInterface
     */
    public function add( array $data ): ActiveRecordInterface
    {
        $data = $this->prepareAddParams($data);

        $model = $this->create( $data );

        $this->beforeSave($model);

        $model->save();

        $this->afterSave($model);

        return $model;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function prepareAddParams( array $data ): array
    {
        return $data;
    }

    /**
     * @param ActiveRecordInterface $model
     *
     * @return void
     */
    public function beforeSave( ActiveRecordInterface $model ): void
    {
        // boilerplate
    }

    /**
     * @param ActiveRecordInterface $model
     *
     * @return void
     */
    public function afterSave( ActiveRecordInterface $model ): void
    {
        // boilerplate
    }
}