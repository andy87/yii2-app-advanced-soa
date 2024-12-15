<?php declare(strict_types=1);

namespace yii2\common\components\repositories;

use yii\db\{ Query, ActiveQuery };
use yii2\common\components\core\{ BaseModel, BaseRepository };

/**
 * < Common > `MySqlRepository`
 *
 * @package yii2\common\components\repositories
 */
abstract class MySqlRepository extends BaseRepository
{
    /** @var BaseModel|string  */
    public const MODEL = BaseModel::class;



    /**
     * @return BaseModel|string
     *
     * @tag #core #repository #get
     */
    public function getClassModel(): BaseModel|string
    {
        /** @var static|string $classModel */
        $classModel = static::MODEL;

        return $classModel;
    }

    /**
     * @return ActiveQuery
     *
     * @tag #core #repository #find
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
     *
     * @tag #core #repository #find
     */
    public function findByCriteria(array $criteria): Query
    {
        return $this
            ->find()
            ->where($criteria);
    }
}