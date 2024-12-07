<?php

namespace app\common\components\base\handlers\items\settings;

/**
 * < Common > `HandlerSetups`
 *
 * @package app\common\components\base\handlers\items\setups
 */
class HandlerSettings
{
    public function __construct(
        public string $classHandler,
        public string $classModel,
        public string $classForm,
        public string $classSearchModel,
        public string $classDataProvider,
        public string $classService,
        public string $classProducer,
        public string $classRepository
    ){}
}