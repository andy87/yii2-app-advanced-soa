<?php

namespace common\components\base\managers\source;

use Yii;
use RuntimeException;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\base\UnknownPropertyException;

/**
 * < Common > Менеджер сервисов
 *
 * @package yii2\common\components\managers
 *
 * @tag: #common #manager #service
 */
abstract class SourceManager extends BaseObject
{
    /** @var string Тип */
    protected const string TYPE_HANDLER = 'handler';

    /** @var string Тип */
    protected const string TYPE_SERVICE = 'service';

    /** @var string Тип */
    protected const string TYPE_REPOSITORY = 'repository';





    /**
     * Массив экземпляров сервисов
     *
     * @var BaseObject[] $_listInstance
     */
    private array $_listInstance = [];

    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;

    /** @var string Тип */
    protected string $type;


    /**
     * @throws UnknownPropertyException|InvalidConfigException|RuntimeException
     */
    public function __get($name)
    {
        if ( isset($this->config[$name]) )
        {
            return $this->getItem($name);
        }

        return parent::__get($name);
    }

    /**
     * Получение экземпляра сервиса
     *
     * @param string $name
     *
     * @return BaseObject
     *
     * @throws InvalidConfigException|RuntimeException
     */
    public function getItem( string $name ): BaseObject
    {
        if ( !isset($this->_listInstance[$name]) )
        {
            if ( !isset($this->config[$name]) )
            {
                throw new RuntimeException(__CLASS__ . " config $this->type `$name` - not found");
            }

            $this->setItem($name);
        }

        return $this->_listInstance[$name];
    }

    /**
     * Установка экземпляра сервиса
     *
     * @param string $name
     *
     * @return void
     *
     * @throws InvalidConfigException
     */
    private function setItem( string $name ): void
    {
        $params = $this->getClassParams($name);

        if (array_key_exists('class', $params)) {

            $this->_listInstance[$name] = Yii::createObject($params);

        } else {

            $params = array_values($params);

            $this->_listInstance[$name] = Yii::createObject(...$params);
        }
    }

    /**
     * Получение параметров класса
     *
     * @param string $name
     *
     * @return callable|array
     */
    private function getClassParams( string $name ): callable|array
    {
        return (is_callable($this->config[$name])) ? $this->config[$name]() : $this->config[$name];
    }
}