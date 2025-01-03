<?php declare(strict_types=1);

namespace common\interfaces\models;

use common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common >
 *
 * @package yii2\common\components\interfaces\models
 *
 * @tag: #abstract #common #interface #searchModel
 */
interface SearchModelInterface
{
    /**
     * @param array $params
     *
     * @return SourceActiveDataProvider
     */
    public function search( array $params ): SourceActiveDataProvider;
}