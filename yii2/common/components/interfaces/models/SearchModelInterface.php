<?php declare(strict_types=1);

namespace app\common\components\interfaces\models;

use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common >
 *
 * @package app\common\components\interfaces\models
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