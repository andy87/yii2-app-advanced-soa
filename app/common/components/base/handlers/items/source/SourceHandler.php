<?php declare(strict_types=1);

namespace app\common\components\base\handlers\items\source;

use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use app\common\components\traits\services\HasService;
use app\common\components\base\services\items\BaseService;
use app\common\components\interfaces\handlers\HandlerInterface;
use app\common\components\base\services\items\settings\ServiceSettings;

/**
 * < Common > Родительский абстрактный класс для всех обработчиков
 *
 * @property BaseService $service;
 *
 * @package app\common\components\base\handlers\items\core
 *
 * @tag: #abstract #common #handler #base
 */
abstract class SourceHandler extends BaseObject implements HandlerInterface
{
    use HasService;



    /**
     * @param array $config
     *
     * @throws InvalidConfigException
     */
    public function __construct( array $config = [] )
    {
        $this->setupService();

        parent::__construct($config);
    }

    abstract public function getServiceSettings(): ServiceSettings;
}