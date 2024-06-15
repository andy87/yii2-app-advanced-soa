<?php

namespace app\common\components\services;

use app\common\components\core\{ BaseModel, BaseService };
use yii\db\Exception;

/**
 * < Common > `ModelService`
 *
 * @package app\common\components\services
 */
abstract class ModelService extends BaseService
{
    /** @var string  */
    public const CLASS_MODEL = BaseModel::class;

    /**
     * @return BaseModel|string
     *
     * @tag #core #service #get
     */
    public function getClassModel(): BaseModel|string
    {
        /** @var static|string $classModel */
        $classModel = static::CLASS_MODEL;

        return $classModel;
    }

    /**
     * @param array $attributes
     *
     * @return BaseModel|string
     *
     * @tag #core #service #create
     */
    public function createModel(array $attributes = []): BaseModel|string
    {
        $classModel = $this->getClassModel();

        return new $classModel($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return BaseModel|string
     *
     * @throws Exception
     *
     * @tag #core #service #model #add
     */
    public function addModel(array $attributes = []): BaseModel|string
    {
        $model = $this->createModel($attributes);

        $model->save();

        return $model;
    }
}