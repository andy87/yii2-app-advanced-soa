<?php declare(strict_types=1);

namespace app\common\components\interfaces\producers;

use app\common\components\base\moels\items\source\SourceModel;

/**
 * < Common >
 *
 * @package app\common\components\interfaces\provider
 *
 * @tag: #abstract #common #interface #producer
 */
interface ProducerInterface
{
    public function modelCreate( array $params, bool $runSave = false ): ?SourceModel;

    public function modelAdd( array $params ): ?SourceModel;



    public function formCreate( array $params, bool $runSave = false ): ?SourceModel;

    public function formAdd( array $params ): ?SourceModel;
}