<?php declare(strict_types=1);

namespace yii2\common\components\base\services\items\source;

use yii2\common\components\system\Logger;
use yii2\common\components\base\producers\items\source\SourceProducer;
use yii2\common\components\base\repository\items\source\SourceRepository;
use yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common > Родительский абстрактный класс для всех сервисов
 *  использующих BaseModel
 *
 * @property Logger $logger
 *
 * @package app\common\components\base\services\items\base
 *
 * @tag: #abstract #common #service #base #source
 */
abstract class SourceToolKit extends SourceService
{
    /** @var ?SourceProducer */
    protected ?SourceProducer $_producer = null;

    /** @var ?SourceRepository */
    protected ?SourceRepository $_repository = null;

    /** @var ?SourceActiveDataProvider */
    protected ?SourceActiveDataProvider $_dataProvider = null;
}