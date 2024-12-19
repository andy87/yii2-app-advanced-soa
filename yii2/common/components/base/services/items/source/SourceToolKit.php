<?php declare(strict_types=1);

namespace yii2\common\components\base\services\items\source;

use yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider;
use yii2\common\components\base\producers\items\source\SourceProducer;
use yii2\common\components\base\repository\items\source\SourceRepository;
use yii2\common\components\system\Logger;
use yii2\common\components\traits\has\ToolsKitTrait;

/**
 * < Common > Родительский абстрактный класс для всех сервисов
 *  использующих BaseModel
 *
 * @property Logger $logger
 * @property ?SourceProducer $_producer
 * @property ?SourceRepository $_repository
 *
 * @package app\common\components\base\services\items\base
 *
 * @tag: #abstract #common #service #base #source
 */
abstract class SourceToolKit extends SourceService
{
    use ToolsKitTrait;



    /** @var ?SourceActiveDataProvider */
    protected ?SourceActiveDataProvider $_dataProvider = null;
}