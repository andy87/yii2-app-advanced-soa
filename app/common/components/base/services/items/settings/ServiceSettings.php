<?php

namespace app\common\components\base\services\items\settings;

/**
 * < Common > Настройки для сервисов
 *
 * @package app\common\components\base\services\items\setups
 */
class ServiceSettings
{
    public function __construct(
        public ?string $classModel,
        public ?string $classForm,
        public ?string $classSearchModel,
        public ?string $classDataProvider,
        public ?string $classService,
        public ?string $classProducer,
        public ?string $classRepository,
        public array $config = []
    ){}
}