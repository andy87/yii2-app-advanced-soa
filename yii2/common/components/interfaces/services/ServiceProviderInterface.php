<?php declare(strict_types=1);

namespace yii2\common\components\interfaces\services;

use yii2\common\components\base\providers\items\base\SourceProducer;

/**
 * < Common >
 *
 * @package app\components\interfaces\services
 *
 * @tag: #abstract #common #interface #service #producer
 */
interface ServiceProviderInterface
{
    public function getProvider( string $providerClassName ): SourceProducer;
}