<?php declare(strict_types=1);

namespace app\common\components\services;


use yii\base\Model;
use yii\db\Exception;
use app\common\components\core\BaseService;

/**
 * < Common > `ModelService`
 *
 * @package app\common\components\services
 */
abstract class ModelService extends BaseService
{
    /** @var string  */
    public const CLASS_MODEL = Model::class;

    /**
     * @return Model|string
     *
     * @tag #core #service #get
     */
    public function getClassModel(): Model|string
    {
        /** @var static|string $classModel */
        $classModel = static::CLASS_MODEL;

        return $classModel;
    }

    /**
     * @param array $attributes
     *
     * @return Model|string
     *
     * @tag #core #service #create
     */
    public function createModel(array $attributes = []): Model|string
    {
        $classModel = $this->getClassModel();

        return new $classModel($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Model|string
     *
     * @throws Exception
     *
     * @tag #core #service #model #add
     */
    public function addModel(array $attributes = []): Model|string
    {
        $model = $this->createModel($attributes);

        $model->save();

        return $model;
    }
}