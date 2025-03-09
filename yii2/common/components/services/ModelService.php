<?php declare(strict_types=1);

namespace yii2\common\components\services;

use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\core\BaseProduces;
use yii2\common\components\core\BaseRepository;
use yii2\common\components\core\BaseService;
use yii\{ base\Model, db\ActiveRecord, db\ActiveRecordInterface };

/**
 * < Common > `ModelService`
 *
 * @property-read BaseRepository $repository
 * @property-read BaseProduces $produces
 *
 * @package yii2\common\components\services
 */
abstract class ModelService extends BaseService
{
    use LazyLoadTrait;

    /** @var string */
    private const CLASS_MODEL = ActiveRecord::class;

    /** @var string */
    private const CLASS_REPOSITORY = BaseRepository::class;

    /** @var string */
    private const CLASS_PRODUCES = BaseProduces::class;



    /** @var ActiveRecord|string $modelClass */
    public ActiveRecord|string $modelClass = self::CLASS_MODEL;

    public array $lazyLoadConfig = [
        'repository' => [
            'class' => self::CLASS_REPOSITORY,
            'model' => self::CLASS_MODEL,
        ],
        'produces' => [
            'class' => self::CLASS_PRODUCES,
            'model' => self::CLASS_MODEL,
        ],
    ];


    /**
     * @param array $attributes
     * @param string $scenario
     *
     * @return ActiveRecordInterface
     *
     * @tag #core #service #create
     */
    public function createModel(array $attributes, string $scenario = Model::SCENARIO_DEFAULT ): ActiveRecordInterface
    {
        return $this->produces->create( $attributes, $scenario );
    }

    /**
     * @param array $attributes
     * @param string $scenario
     *
     * @return ActiveRecordInterface
     *
     * @tag #core #service #add
     */
    public function addModel(array $attributes, string $scenario = Model::SCENARIO_DEFAULT ): ActiveRecordInterface
    {
        return $this->produces->create( $attributes, $scenario );
    }

    /**
     * @param int $id
     *
     * @return ?ActiveRecordInterface
     *
     * @tag #core #service #find
     */
    public function findByID( int $id ): ?ActiveRecordInterface
    {
        return $this->repository->finOne( $id );
    }

    /**
     * @param array|string $criteria
     *
     * @return ActiveRecordInterface[]|array
     *
     * @tag #core #service #find
     */
    public function getAllByCriteria(array|string $criteria ): array
    {
        $query = $this->repository->findByCriteria( $criteria );

        /** @var ActiveRecordInterface[]|array $result */
        $result = $query->all();

        return $result;
    }

    /**
     * @param array|string $criteria
     *
     * @return ?ActiveRecordInterface
     *
     * @tag #core #service #find
     */
    public function getByCriteria( array|string $criteria ): ?ActiveRecordInterface
    {
        $query = $this->repository->findByCriteria( $criteria );

        /** @var ?ActiveRecordInterface $result */
        $result = $query->one();

        return $result;
    }
}