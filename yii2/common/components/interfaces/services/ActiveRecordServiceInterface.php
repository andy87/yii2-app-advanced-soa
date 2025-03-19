<?php

namespace yii2\common\components\interfaces\services;

use yii\base\Model;
use yii\db\ActiveRecordInterface;

/**
 * Interface ActiveRecordServiceInterface
 *
 * @package yii2\common\components\interfaces\services
 */
interface ActiveRecordServiceInterface
{
    /**
     * @param array $attributes
     * @param string $scenario
     *
     * @return ActiveRecordInterface
     */
    public function createModel(array $attributes = [], string $scenario = Model::SCENARIO_DEFAULT ): ActiveRecordInterface;

    /**
     * @param array $attributes
     * @param string $scenario
     *
     * @return ActiveRecordInterface
     */
    public function addModel(array $attributes, string $scenario = Model::SCENARIO_DEFAULT ): ActiveRecordInterface;

    /**
     * @param int $id
     *
     * @return ?ActiveRecordInterface
     */
    public function findByID( int $id ): ?ActiveRecordInterface;

    /**
     * @param array|string $criteria
     *
     * @return array
     */
    public function getAllByCriteria(array|string $criteria ): array;

    /**
     * @param array|string $criteria
     *
     * @return ?ActiveRecordInterface
     */
    public function getByCriteria( array|string $criteria ): ?ActiveRecordInterface;
}