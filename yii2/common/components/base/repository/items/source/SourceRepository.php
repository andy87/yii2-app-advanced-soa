<?php declare(strict_types=1);

namespace common\components\base\repository\items\source;

use Exception;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\ActiveQuery;
use yii\base\BaseObject;
use common\components\base\models\items\sources\SourceModel;
use common\components\interfaces\repository\RepositoryInterface;

/**
 * < Common > Родительский абстрактный класс для всех репозиториев
 *  использующих BaseModel
 *
 * @package app\common\components\base\providers
 *
 * @tag: #abstract #common #repository #base #source
 */
abstract class SourceRepository extends BaseObject implements RepositoryInterface
{
    /** @var SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass;

    /** @var SourceModel|string $formClass класс формы */
    public SourceModel|string $formClass;

    /** @var ?Connection */
    public ?Connection $connection = null;

    /** @var array Criteria for active items */
    public array $criteriaActive = [];



    /**
     * @param ActiveRecord|string $modelClass
     * @param ActiveRecord|string $formClass
     * @param array $config
     */
    public function __construct( ActiveRecord|string $modelClass, ActiveRecord|string $formClass, array $config = [] )
    {
        $this->modelClass = $modelClass;

        $this->formClass = $formClass;

        parent::__construct($config);
    }

    /**
     * @param array|string|int|null $criteria = null
     *
     * @return ActiveQuery
     *
     * @throws Exception
     */
    public function findModel(null|array|string|int $criteria = null): ActiveQuery
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->getModelClass();

        return $this->findByModel( $modelClass, $criteria );
    }

    /**
     * @param array|string|int|null $criteria = null
     *
     * @return ActiveQuery
     *
     * @throws Exception
     */
    public function findForm( null|array|string|int $criteria = null): ActiveQuery
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->getFormClass();

        return $this->findByModel( $modelClass, $criteria );
    }

    /**
     * @param ActiveRecord|string|null $classModel
     * @param array|string|int|null $criteria = null
     *
     * @return ActiveQuery
     */
    public function findByModel(ActiveRecord|string|null $classModel, array|string|int|null $criteria = null ): ActiveQuery
    {
        $activeQuery = $classModel::find();

        if ( $criteria )
        {
            if (is_int($criteria)) {
                $criteria = ['id' => $criteria];
            }

            $activeQuery->where($criteria);
        }

        return $activeQuery;
    }

    /**
     * Find active items
     *
     * @param array|string|int|null $criteria = null
     * @param ActiveRecord|string|null $classModel
     *
     * @return ActiveQuery
     */
    public function findActive( null|array|string|int $criteria = null, ActiveRecord|string|null $classModel = null ): ActiveQuery
    {
        $activeQuery = $this->findByModel( $classModel, $criteria );

        if ( count( $this->criteriaActive ) )
        {
            $activeQuery->andFilterWhere( $this->criteriaActive );
        }

        return $activeQuery;
    }

    /**
     * @return ActiveRecord|string
     *
     * @throws Exception
     */
    public function getModelClass(): ActiveRecord|string
    {
        return $this->modelClass;
    }

    /**
     * @return ActiveRecord|string
     *
     * @throws Exception
     */
    public function getFormClass(): ActiveRecord|string
    {
        return $this->formClass;
    }

    /**
     * @param Connection $connection
     *
     * @return static
     */
    public function setConnection( Connection $connection ): static
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @return ?Connection
     */
    public function getConnection(): ?Connection
    {
        return $this->connection;
    }
}