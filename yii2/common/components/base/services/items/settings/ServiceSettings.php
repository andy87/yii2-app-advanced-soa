<?php

namespace yii2\common\components\base\services\items\settings;

use yii\db\ActiveRecordInterface;
use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\interfaces\models\SearchModelInterface;
use yii2\common\components\base\producers\items\source\SourceProducer;
use yii2\common\components\base\repository\items\source\SourceRepository;
use yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common > Настройки для сервисов
 *
 * @package app\common\components\base\services\items\setups
 */
class ServiceSettings
{
    public function __construct(
        public ActiveRecordInterface|string|null $classModel = null,
        public ActiveRecordInterface|string|null $classForm = null,
        public SearchModelInterface|string|null $classSearchModel = null,
        public SourceActiveDataProvider|string|null $classDataProvider = null,
        public BaseService|string|null $classService = null,
        public SourceProducer|string|null $classProducer = null,
        public SourceRepository|string|null $classRepository = null,
        public array $config = []
    ){}
}