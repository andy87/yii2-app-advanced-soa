<?php declare(strict_types=1);

namespace yii2\common\components\base\handlers\items\source;

use yii\base\BaseObject;
use yii2\common\components\traits\services\HasService;
use yii2\common\components\interfaces\handlers\HandlerInterface;
use yii2\common\components\base\services\items\source\SourceToolKit;
use yii2\common\components\base\services\items\settings\ServiceSettings;

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