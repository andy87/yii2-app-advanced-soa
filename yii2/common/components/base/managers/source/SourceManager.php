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
     * Мэппинг классов
     *
     * @var array
     */
    public const array CONFIG = [];

    /**
     * Массив задаваемый в конфигурационном файле
     *
     * @var array $config
     */
    public array $config;

    /** @var string Тип */
    protected string $type;



    /**
     * @param $name
     *
     * @return BaseObject
     *
     * @throws UnknownPropertyException|InvalidConfigException
     */
    public function __get( $name )
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
        if( isset($this->config[$name]) )
        {
            $params = $this->getClassParams($name);

            /** @var BaseObject $object */
            $object = Yii::createObject(...$params);

        } elseif (isset(static::CONFIG[$name])) {

            /** @var BaseObject $object */
            $object = Yii::createObject(['class' => static::CONFIG[$name] ]);
        }

        if (isset($object)) return $object;

        $this->exception("В классе `" . static::class. "` не найдена конфигурация для {$name}" );
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

    /**
     * @param string $message
     *
     * @return void
     */
    protected function exception(string $message): void
    {
        Yii::error([date('Y-m-d H-i-s'), $message]);

        throw new RuntimeException($message);
    }
}