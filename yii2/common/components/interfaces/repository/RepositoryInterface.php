<?php declare(strict_types=1);

namespace common\components\interfaces\repository;

use common\components\base\models\items\sources\SourceModel;
use yii\db\ActiveQuery;

/**
 * < Common >
 *
 * @package app\common\components\interfaces\repository
 *
 * @tag: #abstract #common #interface #repository
 */
interface RepositoryInterface
{
    public function findModel(array|string|int|null $criteria = null ): ?ActiveQuery;

    public function findForm( array|string|int|null $criteria = null ): ?ActiveQuery;

    public function findByModel(SourceModel|string|null $classModel, array|string|int|null $criteria = null ): ?ActiveQuery;

    public function findActive( array|string|int|null $criteria = null, SourceModel|string|null $classModel = null ): ?ActiveQuery;
}