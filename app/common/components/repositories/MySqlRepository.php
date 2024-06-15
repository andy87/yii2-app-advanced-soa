<?php declare(strict_types=1);

namespace app\common\components\repositories;

use yii\db\{Query, ActiveQuery};
use app\common\components\core\{BaseModel, BaseRepository};

/**
 * < Common > `MySqlRepository`
 *
 * @package app\common\components\repositories
 */
abstract class MySqlRepository extends BaseRepository
{
    /** @var BaseModel|string  */
    public const MODEL = BaseModel::class;



    /**
     * @return BaseModel|string
     */
    public function getClassModel(): BaseModel|string
    {
        /** @var static|string $classModel */
        $classModel = static::MODEL;

        return $classModel;
    }

    /**
     * @return ActiveQuery
     */
    public function find(): ActiveQuery
    {
        $classModel = $this->getClassModel();

        return $classModel::find();
    }

    /**
     * @param array $criteria
     *
     * @return Query
     */
    public function findByCriteria(array $criteria): Query
    {
        return $this
            ->find()
            ->where($criteria);
    }
}