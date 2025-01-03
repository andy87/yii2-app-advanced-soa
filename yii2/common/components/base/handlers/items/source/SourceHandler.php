<?php declare(strict_types=1);

namespace common\components\base\handlers\items\source;

use yii\base\BaseObject;
use common\components\traits\services\HasService;
use common\components\interfaces\handlers\HandlerInterface;
use common\components\base\services\items\source\SourceToolKit;
use common\components\base\services\items\settings\ServiceSettings;

/**
 * < Common > Родительский абстрактный класс для всех обработчиков
 *
 * @property SourceToolKit $service;
 *
 * @package app\common\components\base\handlers\items\core
 *
 * @tag: #abstract #common #handler #base
 */
abstract class SourceHandler extends BaseObject implements HandlerInterface
{
    use HasService;



    /**
     * @var array Настройки для сервиса
     */
    public const SETTINGS_SERVICE = [];



    /**
     * @return ServiceSettings
     */
    public function getServiceSettings(): ServiceSettings
    {
        return new ServiceSettings(...static::SETTINGS_SERVICE);
    }
}