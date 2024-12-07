<?php declare(strict_types=1);

namespace app\common\components\base\producers\items\source;

use Throwable;
use yii\base\BaseObject;
use yii\db\Exception;
use yii\db\StaleObjectException;
use app\common\components\system\Manager;
use app\common\components\base\moels\items\source\SourceModel;
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
     *
     * @throws Exception
     */
    public function modelCreate( mixed $params = [], bool $runSave = false ): ?SourceModel
    {
        /** @var ?SourceModel $model */
        $model = $this->model->create($params);

        return $model;
    }

    /**
     * @param array $params
     *
     * @throws Exception
     */
    public function modelAdd( mixed $params ): ?SourceModel
    {
        return $this->modelCreate( $params, true );
    }

    /**
     * @param array $params
     *
     * @throws Exception
     */
    public function formCreate( mixed $params = [], bool $runSave = false ): ?SourceModel
    {
        /** @var ?SourceModel $form */
        $form = $this->form->create( $params, $runSave );

        return $form;
    }

    /**
     * @param array $params
     *
     * @throws Exception
     */
    public function formAdd( mixed $params ): ?SourceModel
    {
        return $this->formCreate( $params, true );
    }
}