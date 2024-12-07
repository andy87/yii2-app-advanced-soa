<?php declare(strict_types=1);

namespace app\common\components\base\producers\items\source;

use yii\base\Model;
use yii\db\Exception;
use yii\db\ActiveRecord;
use yii\base\BaseObject;
use app\common\components\system\Manager;
use app\common\components\interfaces\producers\ProducerInterface;

/**
 * < Common > Родительский абстрактный класс для всех провайдеров
 *  использующих BaseModel
 *
 * @package app\common\components\base\producers
 *
 * @tag: #abstract #common #producer #base #source
 */
abstract class SourceProducer extends BaseObject implements ProducerInterface
{
    /** @var Manager */
    public Manager $model;

    /** @var ?Manager */
    public ?Manager $form = null;



    /**
     * @param Manager $modelManager
     * @param ?Manager $formManager
     *
     * @param array $config
     */
    public function __construct( Manager $modelManager, Manager $formManager = null, array $config = [] )
    {
        $this->model = $modelManager;

        $this->form = $formManager;

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