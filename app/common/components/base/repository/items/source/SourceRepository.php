<?php declare(strict_types=1);

namespace app\common\components\base\repository\items\source;

use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\interfaces\repository\RepositoryInterface;
use app\common\components\system\Logger;
use Exception;
use JsonException;
use yii\base\BaseObject;
use yii\db\ActiveQuery;
use yii\db\Connection;

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
    protected SourceModel|string $modelClass;

    /** @var ?Connection */
    public ?Connection $connection = null;

    /** @var array Criteria for active items */
    protected array $criteriaActive = [];


    /**
     * @param string $modelClass
     * @param array $criteriaActive
     * @param array $config
     */
    public function __construct( string $modelClass, array $criteriaActive = [], array $config = [] )
    {
        $this->modelClass = $modelClass;

        $this->criteriaActive = $criteriaActive;

        parent::__construct($config);
    }

    /**
     * Create new find query
     *
     * @param null|array|string|int $criteria = null
     *
     * @return ActiveQuery
     *
     * @throws Exception
     */
    public function find( null|array|string|int $criteria = null ): ActiveQuery
    {
        $modelClass = $this->getModelClass();

        $activeQuery = $modelClass::find();

        if ( $criteria )
        {
            $activeQuery->where($criteria);
        }

        return $activeQuery;
    }

    /**
     * Find active items
     *
     * @param null|array|string|int $criteria = null
     *
     * @return ActiveQuery
     *
     * @throws Exception
     */
    public function findActive( null|array|string|int $criteria = null ): ActiveQuery
    {
        $activeQuery = $this->find( $criteria );

        if ( count( $this->criteriaActive ) )
        {
            $activeQuery->andFilterWhere( $this->criteriaActive );
        }

        return $activeQuery;
    }

    /**
     * @return SourceModel|string
     *
     * @throws Exception
     */
    public function getModelClass(): SourceModel|string
    {
        return $this->modelClass;
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