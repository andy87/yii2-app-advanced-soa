<?php declare(strict_types=1);

namespace yii2\common\components\core;

use yii\base\BaseObject;
use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecordInterface;
use yii2\common\components\traits\ActiveRecordManagerTrait;

/**
 * < Common > `BaseRepository`
 *
 * @package yii2\common\components\core
 */
abstract class BaseRepository extends BaseObject
{
    use ActiveRecordManagerTrait;


    /** @var ActiveRecordInterface|string  Класс модели */
    public ActiveRecordInterface|string $modelClass;



    /**
     * @return ActiveQueryInterface
     */
    public function find(): ActiveQueryInterface
    {
        $class = $this->getModelClass();

        return $class::find();
    }

    /**
     * @param array|string $criteria
     *
     * @return ActiveQueryInterface
     */
    public function findByCriteria( array|string $criteria ): ActiveQueryInterface
    {
        return $this->find()->where( $criteria );
    }

    /**
     * @param int $id
     *
     * @return ?ActiveRecordInterface
     */
    public function finOne( int $id ): ?ActiveRecordInterface
    {
        $class = $this->getModelClass();

        return $class::findOne($id);
    }
}