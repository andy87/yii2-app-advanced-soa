<?php

namespace app\common\components\base\handlers\items\settings;

use app\common\components\base\services\items\BaseService;
use app\common\components\base\models\items\sources\SourceModel;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\base\handlers\items\source\SourceHandler;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\repository\items\source\SourceRepository;
use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common > `HandlerSetups`
 *
 * @package app\common\components\base\handlers\items\setups
 */
class HandlerSettings
{
    public function __construct(
        public SourceHandler|string|null $classHandler = null,
        public SourceModel|string|null $classModel = null,
        public SourceModel|string|null $classForm = null,
        public SearchModelInterface|string|null $classSearchModel = null,
        public SourceActiveDataProvider|string|null $classDataProvider = null,
        public BaseService|string|null $classService = null,
        public SourceProducer|string|null $classProducer = null,
        public SourceRepository|string|null $classRepository = null,
        public array $config = []
    ){}
}