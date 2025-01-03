<?php declare(strict_types=1);

namespace common\interfaces\services;

use common\components\base\providers\items\base\SourceProducer;

/**
 * < Common >
 *
 * @package yii2\components\interfaces\services
 *
 * @tag: #abstract #common #interface #service #producer
 */
interface ServiceProviderInterface
{
    public function getProvider( string $providerClassName ): SourceProducer;
}