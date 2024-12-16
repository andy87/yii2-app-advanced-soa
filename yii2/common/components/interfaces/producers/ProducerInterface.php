<?php declare(strict_types=1);

namespace yii2\common\components\interfaces\producers;

use yii\base\Model;

/**
 * < Common >
 *
 * @package app\common\components\interfaces\provider
 *
 * @tag: #abstract #common #interface #producer
 */
interface ProducerInterface
{
    public function modelCreate( array $params ): ?Model;

    public function modelAdd( array $params ): ?Model;



    public function formCreate( array $params ): ?Model;

    public function formAdd( array $params ): ?Model;
}