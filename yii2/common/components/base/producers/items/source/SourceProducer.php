<?php declare(strict_types=1);

namespace common\components\base\producers\items\source;

use yii\base\Model;
use yii\db\Exception;
use yii\db\ActiveRecord;
use yii\base\BaseObject;
use common\components\system\Operator;
use common\interfaces\producers\ProducerInterface;

/**
 * < Common > Родительский абстрактный класс для всех провайдеров
 *  использующих BaseModel
 *
 * @package yii2\common\components\base\producers
 *
 * @tag: #abstract #common #producer #base #source
 */
abstract class SourceProducer extends BaseObject implements ProducerInterface
{
    /** @var Operator */
    public Operator $model;

    /** @var ?Operator */
    public ?Operator $form;



    /**
     * @param Operator $modelOperator
     * @param ?Operator $formOperator
     *
     * @param array $config
     */
    public function __construct(Operator $modelOperator, ?Operator $formOperator = null, array $config = [] )
    {
        $this->model = $modelOperator;

        $this->form = $formOperator;

        parent::__construct($config);
    }

    /**
     * @param array $params
     */
    public function modelCreate( mixed $params = [] ): Model
    {
        return $this->model->create($params);
    }

    /**
     * @param array $params
     *
     * @throws Exception
     */
    public function modelAdd( mixed $params ): ActiveRecord
    {
        /** @var ActiveRecord $model */
        $model = $this->modelCreate( $params );

        $model->save();

        return $model;
    }

    /**
     * @param array $params
     */
    public function formCreate( mixed $params = [] ): Model
    {
        return $this->form->create( $params);
    }

    /**
     * @param array $params
     *
     * @throws Exception
     */
    public function formAdd( mixed $params ): ActiveRecord
    {
        /** @var ActiveRecord $form */
        $form = $this->formCreate( $params );

        $form->save();

        return $form;
    }
}