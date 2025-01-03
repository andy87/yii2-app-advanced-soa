<?php

namespace common\components\system;

use yii\db\Exception;
use yii\db\ActiveRecord;
use yii\base\BaseObject;

/**
 * Class Manager
 *
 * @package yii2\common\components
 *
 * @tag: #manager #common
 */
class Operator extends BaseObject
{
    /** @var ActiveRecord|string $modelClass класс модели */
    private ActiveRecord|string $modelClass;

    /** @var array  */
    public array $defaultParams = [];



    /**
     * @param string $modelClass
     * @param array $defaultParams
     * @param array $config
     */
    public function __construct(string $modelClass, array $defaultParams = [], array $config = [] )
    {
        parent::__construct($config);

        $this->modelClass = $modelClass;

        $this->defaultParams = $defaultParams;
    }

    /**
     * @return ActiveRecord|string
     */
    public function getClassName(): ActiveRecord|string
    {
        return $this->modelClass;
    }

    /**
     * @param array $params
     *
     * @return ActiveRecord
     */
    public function create( array $params ): ActiveRecord
    {
        $className = $this->getClassName();

        $activeRecord = new $className();

        $params = array_merge($this->defaultParams, $params);

        $activeRecord->load( $params, '' );

        return $activeRecord;
    }

    /**
     * @param array $params
     *
     * @return ActiveRecord
     *
     * @throws Exception
     */
    public function add( array $params ): ActiveRecord
    {
        $activeRecord = $this->create($params);

        $activeRecord->save();

        return $activeRecord;
    }
}