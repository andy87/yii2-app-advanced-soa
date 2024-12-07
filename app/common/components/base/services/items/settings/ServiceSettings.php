<?php

namespace app\common\components\base\services\items\settings;

use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;
use app\common\components\base\models\items\sources\SourceModel;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\repository\items\source\SourceRepository;
use app\common\components\base\services\items\BaseService;
use app\common\components\interfaces\models\SearchModelInterface;

/**
 * < Common > Настройки для сервисов
 *
 * @package app\common\components\base\services\items\setups
 */
class ServiceSettings
{
    public function __construct(
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