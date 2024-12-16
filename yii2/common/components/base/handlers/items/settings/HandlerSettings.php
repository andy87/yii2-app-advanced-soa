<?php

namespace yii2\common\components\base\handlers\items\settings;

use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\interfaces\models\SearchModelInterface;
use yii2\common\components\base\handlers\items\source\SourceHandler;
use yii2\common\components\base\producers\items\source\SourceProducer;
use yii2\common\components\base\repository\items\source\SourceRepository;
use yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

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